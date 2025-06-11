<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskmasterService;
use Illuminate\Http\JsonResponse;

/**
 * TaskmasterController - Manage AI-driven tasks within Laravel
 */
class TaskmasterController
{
    /**
     * @var TaskmasterService
     */
    protected $taskmaster;
    
    public function __construct(TaskmasterService $taskmaster)
    {
        $this->taskmaster = $taskmaster;
    }
    
    /**
     * Display the taskmaster dashboard
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = $this->taskmaster->getTaskStats();
        $nextTask = $this->taskmaster->getNextTask();
        $isConfigured = $this->taskmaster->isConfigured();
        
        return view('taskmaster.dashboard', compact('stats', 'nextTask', 'isConfigured'));
    }
    
    /**
     * Get all tasks as JSON
     * 
     * @return JsonResponse
     */
    public function getTasks()
    {
        $tasks = $this->taskmaster->getTasks();
        return response()->json($tasks);
    }
    
    /**
     * Get specific task details
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function getTask($id)
    {
        $task = $this->taskmaster->getTask($id);
        
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        
        return response()->json($task);
    }
    
    /**
     * Update task status
     * 
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        
        if (!in_array($status, ['pending', 'in-progress', 'done', 'cancelled', 'deferred'])) {
            return response()->json(['error' => 'Invalid status'], 400);
        }
        
        $success = $this->taskmaster->updateTaskStatus($id, $status);
        
        if ($success) {
            return response()->json(['message' => 'Status updated successfully']);
        }
        
        return response()->json(['error' => 'Failed to update status'], 500);
    }
    
    /**
     * Add a new task
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function addTask(Request $request)
    {
        $prompt = $request->input('prompt');
        $priority = $request->input('priority', 'medium');
        $dependencies = $request->input('dependencies', []);
        
        if (empty($prompt)) {
            return response()->json(['error' => 'Prompt is required'], 400);
        }
        
        $success = $this->taskmaster->addTask($prompt, [
            'priority' => $priority,
            'dependencies' => $dependencies
        ]);
        
        if ($success) {
            return response()->json(['message' => 'Task added successfully']);
        }
        
        return response()->json(['error' => 'Failed to add task'], 500);
    }
    
    /**
     * Generate content analysis task for a blog post
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function analyzeContent(Request $request)
    {
        $postId = $request->input('post_id');
        $title = $request->input('title');
        $content = $request->input('content');
        
        if (!$postId || !$title || !$content) {
            return response()->json(['error' => 'Post ID, title, and content are required'], 400);
        }
        
        $success = $this->taskmaster->generateContentAnalysisTask($postId, $title, $content);
        
        if ($success) {
            return response()->json(['message' => 'Content analysis task created successfully']);
        }
        
        return response()->json(['error' => 'Failed to create content analysis task'], 500);
    }
    
    /**
     * Get task statistics
     * 
     * @return JsonResponse
     */
    public function getStats()
    {
        $stats = $this->taskmaster->getTaskStats();
        return response()->json($stats);
    }
    
    /**
     * Check taskmaster configuration status
     * 
     * @return JsonResponse
     */
    public function checkConfig()
    {
        $isConfigured = $this->taskmaster->isConfigured();
        return response()->json(['configured' => $isConfigured]);
    }
} 