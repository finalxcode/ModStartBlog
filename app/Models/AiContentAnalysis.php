<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AiContentAnalysis Model - Represents AI content analysis results
 */
class AiContentAnalysis extends Model
{
    protected $table = 'ai_content_analysis';
    
    protected $fillable = [
        'blog_post_id', 'related_task_id',
        'word_count', 'paragraph_count', 'readability_score',
        'seo_score', 'suggested_keywords', 'meta_description_suggestion', 'title_suggestions',
        'content_quality_score', 'improvement_suggestions', 'tone_analysis',
        'ai_model_used', 'analysis_date', 'raw_ai_response'
    ];
    
    protected $dates = [
        'analysis_date', 'created_at', 'updated_at'
    ];
    
    protected $casts = [
        'suggested_keywords' => 'array',
        'title_suggestions' => 'array',
        'improvement_suggestions' => 'array',
        'tone_analysis' => 'array',
        'raw_ai_response' => 'array'
    ];
    
    /**
     * Get the related task
     */
    public function task()
    {
        return $this->belongsTo(AiTask::class, 'related_task_id', 'task_id');
    }
    
    /**
     * Get readability score as percentage
     */
    public function getReadabilityPercentageAttribute()
    {
        return $this->readability_score ? round($this->readability_score, 1) . '%' : null;
    }
    
    /**
     * Get SEO score as percentage
     */
    public function getSeoPercentageAttribute()
    {
        return $this->seo_score ? round($this->seo_score, 1) . '%' : null;
    }
    
    /**
     * Get content quality score as percentage
     */
    public function getQualityPercentageAttribute()
    {
        return $this->content_quality_score ? round($this->content_quality_score, 1) . '%' : null;
    }
    
    /**
     * Get overall score (average of all metrics)
     */
    public function getOverallScoreAttribute()
    {
        $scores = array_filter([
            $this->readability_score,
            $this->seo_score,
            $this->content_quality_score
        ]);
        
        if (empty($scores)) {
            return null;
        }
        
        return round(array_sum($scores) / count($scores), 1);
    }
    
    /**
     * Get score color for UI display
     */
    public function getScoreColor($score)
    {
        if (!$score) return 'gray';
        
        if ($score >= 80) return 'green';
        if ($score >= 60) return 'yellow';
        if ($score >= 40) return 'orange';
        return 'red';
    }
} 