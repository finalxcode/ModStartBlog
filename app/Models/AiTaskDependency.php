<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AiTaskDependency Model - Represents task dependency relationships
 */
class AiTaskDependency extends Model
{
    protected $table = 'ai_task_dependencies';
    
    protected $fillable = [
        'task_id', 'depends_on_task_id'
    ];
    
    /**
     * Get the task that has the dependency
     */
    public function task()
    {
        return $this->belongsTo(AiTask::class, 'task_id', 'task_id');
    }
    
    /**
     * Get the task that is depended upon
     */
    public function dependsOnTask()
    {
        return $this->belongsTo(AiTask::class, 'depends_on_task_id', 'task_id');
    }
} 