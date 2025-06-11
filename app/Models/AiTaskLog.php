<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AiTaskLog Model - Represents task activity logs
 */
class AiTaskLog extends Model
{
    protected $table = 'ai_task_logs';
    
    protected $fillable = [
        'task_id', 'action', 'old_value', 'new_value', 
        'details', 'user_id', 'source'
    ];
    
    /**
     * Action constants
     */
    const ACTION_CREATED = 'created';
    const ACTION_STATUS_CHANGED = 'status_changed';
    const ACTION_UPDATED = 'updated';
    const ACTION_ASSIGNED = 'assigned';
    const ACTION_COMPLETED = 'completed';
    const ACTION_AI_ANALYSIS = 'ai_analysis';
    
    /**
     * Source constants
     */
    const SOURCE_MANUAL = 'manual';
    const SOURCE_AI = 'ai';
    const SOURCE_SYSTEM = 'system';
    
    /**
     * Get the related task
     */
    public function task()
    {
        return $this->belongsTo(AiTask::class, 'task_id', 'task_id');
    }
    
    /**
     * Get all valid actions
     */
    public static function getValidActions()
    {
        return [
            self::ACTION_CREATED,
            self::ACTION_STATUS_CHANGED,
            self::ACTION_UPDATED,
            self::ACTION_ASSIGNED,
            self::ACTION_COMPLETED,
            self::ACTION_AI_ANALYSIS
        ];
    }
    
    /**
     * Get all valid sources
     */
    public static function getValidSources()
    {
        return [
            self::SOURCE_MANUAL,
            self::SOURCE_AI,
            self::SOURCE_SYSTEM
        ];
    }
} 