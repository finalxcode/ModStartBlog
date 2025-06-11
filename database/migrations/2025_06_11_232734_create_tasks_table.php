<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            // Basic task information
            $table->string('task_id', 50)->comment('Taskmaster task ID (e.g., 1, 1.1)')->nullable();
            $table->string('title', 255)->comment('Task title')->nullable();
            $table->text('description')->comment('Task description')->nullable();
            $table->text('details')->comment('Implementation details')->nullable();
            
            // Task status and priority
            $table->enum('status', ['pending', 'in-progress', 'done', 'cancelled', 'deferred', 'blocked'])
                  ->default('pending')->comment('Task status');
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium')->comment('Task priority');
            
            // Relationships and dependencies
            $table->string('parent_task_id', 50)->comment('Parent task ID for subtasks')->nullable();
            $table->text('dependencies')->comment('JSON array of dependency task IDs')->nullable();
            
            // AI and content related fields
            $table->enum('task_type', ['general', 'content_analysis', 'seo_optimization', 'blog_enhancement', 'automated_tagging'])
                  ->default('general')->comment('Type of AI task');
            $table->unsignedInteger('related_blog_post_id')->comment('Related blog post ID if applicable')->nullable();
            $table->text('ai_metadata')->comment('AI analysis results and metadata as JSON')->nullable();
            
            // Scheduling and tracking
            $table->timestamp('due_date')->comment('Task due date')->nullable();
            $table->timestamp('started_at')->comment('When task was started')->nullable();
            $table->timestamp('completed_at')->comment('When task was completed')->nullable();
            
            // Assignment and ownership
            $table->unsignedInteger('assigned_user_id')->comment('Assigned user ID')->nullable();
            $table->unsignedInteger('created_by_user_id')->comment('User who created the task')->nullable();
            
            // Performance tracking
            $table->unsignedInteger('estimated_minutes')->comment('Estimated completion time in minutes')->nullable();
            $table->unsignedInteger('actual_minutes')->comment('Actual completion time in minutes')->nullable();
            $table->text('completion_notes')->comment('Notes added upon completion')->nullable();
            
            // Indexes for performance
            $table->index('task_id');
            $table->index('status');
            $table->index('priority');
            $table->index('parent_task_id');
            $table->index('task_type');
            $table->index('related_blog_post_id');
            $table->index('assigned_user_id');
            $table->index('created_by_user_id');
            $table->index('due_date');
            $table->index(['status', 'priority']);
        });

        Schema::create('ai_task_dependencies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->string('task_id', 50)->comment('Task that depends on another');
            $table->string('depends_on_task_id', 50)->comment('Task that is dependency');
            
            $table->index('task_id');
            $table->index('depends_on_task_id');
            $table->unique(['task_id', 'depends_on_task_id'], 'unique_dependency');
        });

        Schema::create('ai_task_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->string('task_id', 50)->comment('Related task ID');
            $table->enum('action', ['created', 'status_changed', 'updated', 'assigned', 'completed', 'ai_analysis'])
                  ->comment('Type of action performed');
            $table->string('old_value', 255)->comment('Previous value before change')->nullable();
            $table->string('new_value', 255)->comment('New value after change')->nullable();
            $table->text('details')->comment('Additional details about the action')->nullable();
            $table->unsignedInteger('user_id')->comment('User who performed the action')->nullable();
            $table->string('source', 50)->default('manual')->comment('Source of action: manual, ai, system');
            
            $table->index('task_id');
            $table->index('action');
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::create('ai_content_analysis', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->unsignedInteger('blog_post_id')->comment('Related blog post ID');
            $table->string('related_task_id', 50)->comment('Related AI task ID')->nullable();
            
            // Content metrics
            $table->unsignedInteger('word_count')->comment('Article word count')->nullable();
            $table->unsignedInteger('paragraph_count')->comment('Number of paragraphs')->nullable();
            $table->decimal('readability_score', 5, 2)->comment('Readability score (0-100)')->nullable();
            
            // SEO analysis
            $table->decimal('seo_score', 5, 2)->comment('SEO optimization score (0-100)')->nullable();
            $table->text('suggested_keywords')->comment('AI suggested keywords as JSON')->nullable();
            $table->text('meta_description_suggestion')->comment('Suggested meta description')->nullable();
            $table->text('title_suggestions')->comment('Alternative title suggestions as JSON')->nullable();
            
            // Content quality
            $table->decimal('content_quality_score', 5, 2)->comment('Overall content quality (0-100)')->nullable();
            $table->text('improvement_suggestions')->comment('AI suggestions for improvement as JSON')->nullable();
            $table->text('tone_analysis')->comment('Content tone analysis results as JSON')->nullable();
            
            // AI metadata
            $table->string('ai_model_used', 100)->comment('AI model used for analysis')->nullable();
            $table->timestamp('analysis_date')->comment('When analysis was performed')->nullable();
            $table->text('raw_ai_response')->comment('Full AI analysis response')->nullable();
            
            $table->index('blog_post_id');
            $table->index('related_task_id');
            $table->index('analysis_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_content_analysis');
        Schema::dropIfExists('ai_task_logs');
        Schema::dropIfExists('ai_task_dependencies');
        Schema::dropIfExists('ai_tasks');
    }
} 