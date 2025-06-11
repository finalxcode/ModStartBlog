<?php

namespace App\Services;

use App\Models\AiTask;
use App\Models\AiTaskDependency;
use App\Models\AiTaskLog;
use Illuminate\Support\Facades\Log;

/**
 * TaskDatabaseSync - Synchronizes taskmaster-ai JSON data with Laravel database
 * 
 * This service bridges the gap between taskmaster-ai's JSON-based task storage
 * and Laravel's database-driven approach for enhanced querying and reporting.
 */
class TaskDatabaseSync
{
    /**
     * @var TaskmasterService
     */
    private $taskmaster;
    
    public function __construct(TaskmasterService $taskmaster)
    {
        $this->taskmaster = $taskmaster;
    }
    
    /**
     * Sync all tasks from taskmaster JSON to database
     * 
     * @return array
     */
    public function syncAllTasks()
    {
        try {
            $tasks = $this->taskmaster->getTasks();
            if (!$tasks) {
                return ['status' => 'error', 'message' => 'Could not retrieve tasks from taskmaster'];
            }
            
            $synced = 0;
            $errors = [];
            
            foreach ($tasks as $task) {
                try {
                    $this->syncTask($task);
                    $synced++;
                } catch (\Exception $e) {
                    $errors[] = "Error syncing task {$task['id']}: " . $e->getMessage();
                    Log::error("Task sync error for task {$task['id']}", ['error' => $e->getMessage()]);
                }
            }
            
            // Sync dependencies after all tasks are created
            $this->syncAllDependencies($tasks);
            
            return [
                'status' => 'success',
                'synced' => $synced,
                'errors' => $errors,
                'total' => count($tasks)
            ];
            
        } catch (\Exception $e) {
            Log::error('Task sync failed', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Sync a single task from taskmaster JSON to database
     * 
     * @param array $taskData
     * @return AiTask
     */
    public function syncTask($taskData)
    {
        $existingTask = AiTask::where('task_id', $taskData['id'])->first();
        
        $data = [
            'task_id' => $taskData['id'],
            'title' => isset($taskData['title']) ? $taskData['title'] : null,
            'description' => isset($taskData['description']) ? $taskData['description'] : null,
            'details' => isset($taskData['details']) ? $taskData['details'] : null,
            'status' => isset($taskData['status']) ? $taskData['status'] : 'pending',
            'priority' => isset($taskData['priority']) ? $taskData['priority'] : 'medium',
            'parent_task_id' => $this->extractParentTaskId($taskData['id']),
            'dependencies' => isset($taskData['dependencies']) ? json_encode($taskData['dependencies']) : null,
            'task_type' => $this->determineTaskType($taskData),
            'ai_metadata' => $this->extractAiMetadata($taskData)
        ];
        
        if ($existingTask) {
            // Check if status changed for logging
            $oldStatus = $existingTask->status;
            $newStatus = $data['status'];
            
            $existingTask->update($data);
            
            // Log status change if it occurred
            if ($oldStatus !== $newStatus) {
                $this->logTaskAction($existingTask->task_id, 'status_changed', $oldStatus, $newStatus, 'Synced from taskmaster');
            }
            
            return $existingTask;
        } else {
            $task = AiTask::create($data);
            $this->logTaskAction($task->task_id, 'created', null, 'created', 'Created from taskmaster sync');
            return $task;
        }
    }
    
    /**
     * Sync dependencies for all tasks
     * 
     * @param array $tasks
     */
    private function syncAllDependencies($tasks)
    {
        // Clear existing dependencies first
        AiTaskDependency::truncate();
        
        foreach ($tasks as $task) {
            if (isset($task['dependencies']) && is_array($task['dependencies'])) {
                foreach ($task['dependencies'] as $dependencyId) {
                    AiTaskDependency::firstOrCreate([
                        'task_id' => $task['id'],
                        'depends_on_task_id' => $dependencyId
                    ]);
                }
            }
        }
    }
    
    /**
     * Extract parent task ID from task ID (e.g., "1.2" -> "1")
     * 
     * @param string $taskId
     * @return string|null
     */
    private function extractParentTaskId($taskId)
    {
        if (strpos($taskId, '.') !== false) {
            return substr($taskId, 0, strpos($taskId, '.'));
        }
        return null;
    }
    
    /**
     * Determine task type based on task content
     * 
     * @param array $taskData
     * @return string
     */
    private function determineTaskType($taskData)
    {
        $title = isset($taskData['title']) ? strtolower($taskData['title']) : '';
        $description = isset($taskData['description']) ? strtolower($taskData['description']) : '';
        $details = isset($taskData['details']) ? strtolower($taskData['details']) : '';
        
        $content = $title . ' ' . $description . ' ' . $details;
        
        if (strpos($content, 'content analysis') !== false || strpos($content, 'analyze content') !== false) {
            return 'content_analysis';
        }
        
        if (strpos($content, 'seo') !== false || strpos($content, 'search engine') !== false) {
            return 'seo_optimization';
        }
        
        if (strpos($content, 'blog') !== false && strpos($content, 'enhance') !== false) {
            return 'blog_enhancement';
        }
        
        if (strpos($content, 'tag') !== false && strpos($content, 'automat') !== false) {
            return 'automated_tagging';
        }
        
        return 'general';
    }
    
    /**
     * Extract AI metadata from task data
     * 
     * @param array $taskData
     * @return string|null
     */
    private function extractAiMetadata($taskData)
    {
        $metadata = [];
        
        // Add any AI-specific fields
        if (isset($taskData['testStrategy'])) {
            $metadata['testStrategy'] = $taskData['testStrategy'];
        }
        
        if (isset($taskData['subtasks'])) {
            $metadata['subtaskCount'] = count($taskData['subtasks']);
        }
        
        // Add sync timestamp
        $metadata['lastSyncAt'] = date('Y-m-d H:i:s');
        
        return empty($metadata) ? null : json_encode($metadata);
    }
    
    /**
     * Log a task action
     * 
     * @param string $taskId
     * @param string $action
     * @param string|null $oldValue
     * @param string|null $newValue
     * @param string|null $details
     */
    private function logTaskAction($taskId, $action, $oldValue = null, $newValue = null, $details = null)
    {
        AiTaskLog::create([
            'task_id' => $taskId,
            'action' => $action,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'details' => $details,
            'source' => 'system'
        ]);
    }
    
    /**
     * Get sync statistics
     * 
     * @return array
     */
    public function getSyncStats()
    {
        $taskmasterCount = count($this->taskmaster->getTasks());
        $databaseCount = AiTask::count();
        $lastSync = AiTaskLog::where('action', 'created')
                              ->where('source', 'system')
                              ->latest()
                              ->first();
        
        return [
            'taskmaster_tasks' => $taskmasterCount,
            'database_tasks' => $databaseCount,
            'last_sync' => $lastSync ? $lastSync->created_at : null,
            'in_sync' => $taskmasterCount === $databaseCount
        ];
    }
    
    /**
     * Clean orphaned database tasks (not in taskmaster)
     * 
     * @return int Number of cleaned tasks
     */
    public function cleanOrphanedTasks()
    {
        $taskmasterTasks = $this->taskmaster->getTasks();
        $taskmasterIds = array_column($taskmasterTasks, 'id');
        
        $orphaned = AiTask::whereNotIn('task_id', $taskmasterIds)->get();
        $count = $orphaned->count();
        
        foreach ($orphaned as $task) {
            $this->logTaskAction($task->task_id, 'deleted', 'exists', 'deleted', 'Removed orphaned task');
            $task->delete();
        }
        
        return $count;
    }
} 