<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

/**
 * TaskmasterService - Laravel integration with taskmaster-ai
 * 
 * This service provides a bridge between Laravel and the taskmaster-ai system,
 * allowing the blog application to interact with AI-driven task management.
 */
class TaskmasterService
{
    /**
     * The taskmaster-ai executable command
     */
    private $command = 'npx task-master';
    
    /**
     * Project root directory
     */
    private $projectRoot;
    
    public function __construct()
    {
        $this->projectRoot = base_path();
    }
    
    /**
     * Get all tasks from taskmaster
     * 
     * @return array
     */
    public function getTasks()
    {
        try {
            $result = $this->executeCommand('list --format=json');
            return json_decode($result, true) ?: [];
        } catch (Exception $e) {
            Log::error('Failed to get tasks from taskmaster: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get next recommended task
     * 
     * @return array|null
     */
    public function getNextTask()
    {
        try {
            $result = $this->executeCommand('next --format=json');
            return json_decode($result, true);
        } catch (Exception $e) {
            Log::error('Failed to get next task from taskmaster: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get specific task details
     * 
     * @param string $taskId
     * @return array|null
     */
    public function getTask($taskId)
    {
        try {
            $result = $this->executeCommand("show {$taskId} --format=json");
            return json_decode($result, true);
        } catch (Exception $e) {
            Log::error("Failed to get task {$taskId} from taskmaster: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update task status
     * 
     * @param string $taskId
     * @param string $status
     * @return bool
     */
    public function updateTaskStatus($taskId, $status)
    {
        try {
            $this->executeCommand("set-status --id={$taskId} --status={$status}");
            Log::info("Updated task {$taskId} status to {$status}");
            return true;
        } catch (Exception $e) {
            Log::error("Failed to update task {$taskId} status: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Add a new task
     * 
     * @param string $prompt
     * @param array $options
     * @return bool
     */
    public function addTask($prompt, $options = [])
    {
        try {
            $cmd = "add-task --prompt=\"{$prompt}\"";
            
            if (isset($options['priority'])) {
                $cmd .= " --priority={$options['priority']}";
            }
            
            if (isset($options['dependencies'])) {
                $cmd .= " --dependencies=" . implode(',', $options['dependencies']);
            }
            
            $this->executeCommand($cmd);
            Log::info("Added new task: {$prompt}");
            return true;
        } catch (Exception $e) {
            Log::error("Failed to add task: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate content analysis task for a blog post
     * 
     * @param int $postId
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function generateContentAnalysisTask($postId, $title, $content)
    {
        $prompt = "Analyze blog post #{$postId} '{$title}' for content quality, SEO optimization, and readability improvements. Content length: " . strlen($content) . " characters.";
        
        return $this->addTask($prompt, [
            'priority' => 'medium'
        ]);
    }
    
    /**
     * Check if taskmaster is properly configured
     * 
     * @return bool
     */
    public function isConfigured()
    {
        try {
            $this->executeCommand('models');
            return true;
        } catch (Exception $e) {
            Log::warning('Taskmaster not properly configured: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute taskmaster command
     * 
     * @param string $command
     * @return string
     * @throws Exception
     */
    private function executeCommand($command)
    {
        $fullCommand = "{$this->command} {$command}";
        
        // Execute command in project root directory
        $result = shell_exec("cd {$this->projectRoot} && {$fullCommand} 2>&1");
        
        if ($result === null) {
            throw new Exception("Failed to execute taskmaster command: {$fullCommand}");
        }
        
        // Check for error indicators in output
        if (strpos($result, 'Error:') !== false || strpos($result, '[ERROR]') !== false) {
            throw new Exception("Taskmaster command failed: {$result}");
        }
        
        return trim($result);
    }
    
    /**
     * Get task statistics
     * 
     * @return array
     */
    public function getTaskStats()
    {
        $tasks = $this->getTasks();
        
        if (empty($tasks)) {
            return [
                'total' => 0,
                'pending' => 0,
                'in_progress' => 0,
                'done' => 0,
                'completion_rate' => 0
            ];
        }
        
        $stats = [
            'total' => count($tasks),
            'pending' => 0,
            'in_progress' => 0,
            'done' => 0
        ];
        
        foreach ($tasks as $task) {
            $status = isset($task['status']) ? $task['status'] : 'pending';
            if (isset($stats[$status])) {
                $stats[$status]++;
            }
        }
        
        $stats['completion_rate'] = $stats['total'] > 0 
            ? round(($stats['done'] / $stats['total']) * 100, 1) 
            : 0;
        
        return $stats;
    }
} 