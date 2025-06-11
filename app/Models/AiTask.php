<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AiTask Model - Represents AI-driven tasks managed by taskmaster-ai
 * 
 * This model handles the bridge between taskmaster-ai JSON tasks 
 * and Laravel database storage for enhanced tracking and reporting.
 */
class AiTask extends Model
{
    protected $table = 'ai_tasks';
    
    protected $fillable = [
        'task_id', 'title', 'description', 'details',
        'status', 'priority', 'parent_task_id', 'dependencies',
        'task_type', 'related_blog_post_id', 'ai_metadata',
        'due_date', 'started_at', 'completed_at',
        'assigned_user_id', 'created_by_user_id',
        'estimated_minutes', 'actual_minutes', 'completion_notes'
    ];
    
    protected $dates = [
        'due_date', 'started_at', 'completed_at', 'created_at', 'updated_at'
    ];
    
    protected $casts = [
        'dependencies' => 'array',
        'ai_metadata' => 'array'
    ];
    
    /**
     * Task status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in-progress';
    const STATUS_DONE = 'done';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_DEFERRED = 'deferred';
    const STATUS_BLOCKED = 'blocked';
    
    /**
     * Priority constants
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    
    /**
     * Task type constants
     */
    const TYPE_GENERAL = 'general';
    const TYPE_CONTENT_ANALYSIS = 'content_analysis';
    const TYPE_SEO_OPTIMIZATION = 'seo_optimization';
    const TYPE_BLOG_ENHANCEMENT = 'blog_enhancement';
    const TYPE_AUTOMATED_TAGGING = 'automated_tagging';
    
    /**
     * Get all valid statuses
     */
    public static function getValidStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DONE,
            self::STATUS_CANCELLED,
            self::STATUS_DEFERRED,
            self::STATUS_BLOCKED
        ];
    }
    
    /**
     * Get all valid priorities
     */
    public static function getValidPriorities()
    {
        return [
            self::PRIORITY_LOW,
            self::PRIORITY_MEDIUM,
            self::PRIORITY_HIGH
        ];
    }
    
    /**
     * Get all valid task types
     */
    public static function getValidTaskTypes()
    {
        return [
            self::TYPE_GENERAL,
            self::TYPE_CONTENT_ANALYSIS,
            self::TYPE_SEO_OPTIMIZATION,
            self::TYPE_BLOG_ENHANCEMENT,
            self::TYPE_AUTOMATED_TAGGING
        ];
    }
    
    /**
     * Get child tasks (subtasks)
     */
    public function subtasks()
    {
        return $this->hasMany(self::class, 'parent_task_id', 'task_id');
    }
    
    /**
     * Get parent task
     */
    public function parentTask()
    {
        return $this->belongsTo(self::class, 'parent_task_id', 'task_id');
    }
    
    /**
     * Get task dependencies
     */
    public function taskDependencies()
    {
        return $this->hasMany(AiTaskDependency::class, 'task_id', 'task_id');
    }
    
    /**
     * Get tasks that depend on this task
     */
    public function dependentTasks()
    {
        return $this->hasMany(AiTaskDependency::class, 'depends_on_task_id', 'task_id');
    }
    
    /**
     * Get task logs
     */
    public function logs()
    {
        return $this->hasMany(AiTaskLog::class, 'task_id', 'task_id')->orderBy('created_at', 'desc');
    }
    
    /**
     * Get content analysis if task is content-related
     */
    public function contentAnalysis()
    {
        return $this->hasOne(AiContentAnalysis::class, 'related_task_id', 'task_id');
    }
    
    /**
     * Check if task is completed
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_DONE;
    }
    
    /**
     * Check if task is in progress
     */
    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }
    
    /**
     * Check if task is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
    
    /**
     * Check if task is a subtask
     */
    public function isSubtask()
    {
        return !empty($this->parent_task_id);
    }
    
    /**
     * Get estimated completion time in human readable format
     */
    public function getEstimatedTimeAttribute()
    {
        if (!$this->estimated_minutes) {
            return null;
        }
        
        $hours = floor($this->estimated_minutes / 60);
        $minutes = $this->estimated_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }
    
    /**
     * Get actual completion time in human readable format
     */
    public function getActualTimeAttribute()
    {
        if (!$this->actual_minutes) {
            return null;
        }
        
        $hours = floor($this->actual_minutes / 60);
        $minutes = $this->actual_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }
    
    /**
     * Get status color for UI display
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'gray',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_DONE => 'green',
            self::STATUS_CANCELLED => 'red',
            self::STATUS_DEFERRED => 'yellow',
            self::STATUS_BLOCKED => 'orange'
        ];
        
        return isset($colors[$this->status]) ? $colors[$this->status] : 'gray';
    }
    
    /**
     * Get priority color for UI display
     */
    public function getPriorityColorAttribute()
    {
        $colors = [
            self::PRIORITY_LOW => 'green',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_HIGH => 'red'
        ];
        
        return isset($colors[$this->priority]) ? $colors[$this->priority] : 'gray';
    }
    
    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Scope for filtering by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
    
    /**
     * Scope for filtering by task type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('task_type', $type);
    }
    
    /**
     * Scope for getting only parent tasks (not subtasks)
     */
    public function scopeParentTasks($query)
    {
        return $query->whereNull('parent_task_id');
    }
    
    /**
     * Scope for getting only subtasks
     */
    public function scopeSubtasks($query)
    {
        return $query->whereNotNull('parent_task_id');
    }
} 