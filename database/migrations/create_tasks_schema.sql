-- AI Tasks Management Schema for ModStartBlog
-- This creates the database schema for AI-driven task management

-- Main tasks table
CREATE TABLE IF NOT EXISTS `ai_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `task_id` varchar(50) DEFAULT NULL COMMENT 'Taskmaster task ID (e.g., 1, 1.1)',
  `title` varchar(255) DEFAULT NULL COMMENT 'Task title',
  `description` text COMMENT 'Task description',
  `details` text COMMENT 'Implementation details',
  `status` enum('pending','in-progress','done','cancelled','deferred','blocked') NOT NULL DEFAULT 'pending' COMMENT 'Task status',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium' COMMENT 'Task priority',
  `parent_task_id` varchar(50) DEFAULT NULL COMMENT 'Parent task ID for subtasks',
  `dependencies` text COMMENT 'JSON array of dependency task IDs',
  `task_type` enum('general','content_analysis','seo_optimization','blog_enhancement','automated_tagging') NOT NULL DEFAULT 'general' COMMENT 'Type of AI task',
  `related_blog_post_id` int(10) unsigned DEFAULT NULL COMMENT 'Related blog post ID if applicable',
  `ai_metadata` text COMMENT 'AI analysis results and metadata as JSON',
  `due_date` timestamp NULL DEFAULT NULL COMMENT 'Task due date',
  `started_at` timestamp NULL DEFAULT NULL COMMENT 'When task was started',
  `completed_at` timestamp NULL DEFAULT NULL COMMENT 'When task was completed',
  `assigned_user_id` int(10) unsigned DEFAULT NULL COMMENT 'Assigned user ID',
  `created_by_user_id` int(10) unsigned DEFAULT NULL COMMENT 'User who created the task',
  `estimated_minutes` int(10) unsigned DEFAULT NULL COMMENT 'Estimated completion time in minutes',
  `actual_minutes` int(10) unsigned DEFAULT NULL COMMENT 'Actual completion time in minutes',
  `completion_notes` text COMMENT 'Notes added upon completion',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `status` (`status`),
  KEY `priority` (`priority`),
  KEY `parent_task_id` (`parent_task_id`),
  KEY `task_type` (`task_type`),
  KEY `related_blog_post_id` (`related_blog_post_id`),
  KEY `assigned_user_id` (`assigned_user_id`),
  KEY `created_by_user_id` (`created_by_user_id`),
  KEY `due_date` (`due_date`),
  KEY `status_priority` (`status`,`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Task dependencies table
CREATE TABLE IF NOT EXISTS `ai_task_dependencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `task_id` varchar(50) NOT NULL COMMENT 'Task that depends on another',
  `depends_on_task_id` varchar(50) NOT NULL COMMENT 'Task that is dependency',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_dependency` (`task_id`,`depends_on_task_id`),
  KEY `task_id` (`task_id`),
  KEY `depends_on_task_id` (`depends_on_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Task logs table
CREATE TABLE IF NOT EXISTS `ai_task_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `task_id` varchar(50) NOT NULL COMMENT 'Related task ID',
  `action` enum('created','status_changed','updated','assigned','completed','ai_analysis') NOT NULL COMMENT 'Type of action performed',
  `old_value` varchar(255) DEFAULT NULL COMMENT 'Previous value before change',
  `new_value` varchar(255) DEFAULT NULL COMMENT 'New value after change',
  `details` text COMMENT 'Additional details about the action',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'User who performed the action',
  `source` varchar(50) NOT NULL DEFAULT 'manual' COMMENT 'Source of action: manual, ai, system',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `action` (`action`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Content analysis table
CREATE TABLE IF NOT EXISTS `ai_content_analysis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blog_post_id` int(10) unsigned NOT NULL COMMENT 'Related blog post ID',
  `related_task_id` varchar(50) DEFAULT NULL COMMENT 'Related AI task ID',
  `word_count` int(10) unsigned DEFAULT NULL COMMENT 'Article word count',
  `paragraph_count` int(10) unsigned DEFAULT NULL COMMENT 'Number of paragraphs',
  `readability_score` decimal(5,2) DEFAULT NULL COMMENT 'Readability score (0-100)',
  `seo_score` decimal(5,2) DEFAULT NULL COMMENT 'SEO optimization score (0-100)',
  `suggested_keywords` text COMMENT 'AI suggested keywords as JSON',
  `meta_description_suggestion` text COMMENT 'Suggested meta description',
  `title_suggestions` text COMMENT 'Alternative title suggestions as JSON',
  `content_quality_score` decimal(5,2) DEFAULT NULL COMMENT 'Overall content quality (0-100)',
  `improvement_suggestions` text COMMENT 'AI suggestions for improvement as JSON',
  `tone_analysis` text COMMENT 'Content tone analysis results as JSON',
  `ai_model_used` varchar(100) DEFAULT NULL COMMENT 'AI model used for analysis',
  `analysis_date` timestamp NULL DEFAULT NULL COMMENT 'When analysis was performed',
  `raw_ai_response` text COMMENT 'Full AI analysis response',
  PRIMARY KEY (`id`),
  KEY `blog_post_id` (`blog_post_id`),
  KEY `related_task_id` (`related_task_id`),
  KEY `analysis_date` (`analysis_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert a record into migrations table to track this migration
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_06_11_232734_create_tasks_table', 1) 
ON DUPLICATE KEY UPDATE `migration` = VALUES(`migration`); 