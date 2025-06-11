<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TaskmasterService;

class TaskmasterTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskmaster:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test taskmaster-ai integration with Laravel';

    /**
     * The taskmaster service
     *
     * @var TaskmasterService
     */
    protected $taskmaster;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskmasterService $taskmaster)
    {
        parent::__construct();
        $this->taskmaster = $taskmaster;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Testing Taskmaster-AI Integration');
        $this->line('');

        // Test configuration
        $this->info('1. Checking Configuration...');
        $isConfigured = $this->taskmaster->isConfigured();
        
        if ($isConfigured) {
            $this->info('   ✅ Taskmaster is properly configured');
        } else {
            $this->error('   ❌ Taskmaster configuration failed');
            return 1;
        }

        // Test getting tasks
        $this->info('2. Fetching Tasks...');
        $tasks = $this->taskmaster->getTasks();
        $this->info('   📋 Found ' . count($tasks) . ' tasks');

        // Test statistics
        $this->info('3. Getting Statistics...');
        $stats = $this->taskmaster->getTaskStats();
        $this->line('   📊 Statistics:');
        $this->line('      - Total: ' . $stats['total']);
        $this->line('      - Pending: ' . $stats['pending']);
        $this->line('      - In Progress: ' . $stats['in_progress']);
        $this->line('      - Done: ' . $stats['done']);
        $this->line('      - Completion Rate: ' . $stats['completion_rate'] . '%');

        // Test getting next task
        $this->info('4. Getting Next Task...');
        $nextTask = $this->taskmaster->getNextTask();
        
        if ($nextTask) {
            $this->info('   🎯 Next task: ' . ($nextTask['title'] ?: 'Untitled'));
        } else {
            $this->line('   ℹ️  No next task available');
        }

        // Test adding a task (commented out to avoid spam)
        $this->info('5. Testing Task Creation...');
        $testPrompt = 'Test task created from Laravel integration at ' . date('Y-m-d H:i:s');
        $success = $this->taskmaster->addTask($testPrompt, ['priority' => 'low']);
        
        if ($success) {
            $this->info('   ✅ Successfully created test task');
        } else {
            $this->error('   ❌ Failed to create test task');
        }

        $this->line('');
        $this->info('🎉 Taskmaster-AI integration test completed!');
        
        return 0;
    }
} 