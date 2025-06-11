<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TaskDatabaseSync;

class TaskSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:sync 
                           {--clean : Clean orphaned tasks before sync}
                           {--stats : Show sync statistics only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync taskmaster-ai tasks with Laravel database';

    /**
     * The task sync service
     *
     * @var TaskDatabaseSync
     */
    protected $syncService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskDatabaseSync $syncService)
    {
        parent::__construct();
        $this->syncService = $syncService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Task Database Sync Tool');
        $this->info('======================');
        
        // Show stats if requested
        if ($this->option('stats')) {
            $this->showStats();
            return;
        }
        
        // Clean orphaned tasks if requested
        if ($this->option('clean')) {
            $this->info('Cleaning orphaned tasks...');
            $cleaned = $this->syncService->cleanOrphanedTasks();
            $this->info("Cleaned {$cleaned} orphaned tasks.");
        }
        
        // Perform sync
        $this->info('Starting task synchronization...');
        $result = $this->syncService->syncAllTasks();
        
        if ($result['status'] === 'success') {
            $this->info("✅ Sync completed successfully!");
            $this->info("   - Synced: {$result['synced']} tasks");
            $this->info("   - Total: {$result['total']} tasks");
            
            if (!empty($result['errors'])) {
                $this->warn("⚠️  Some errors occurred:");
                foreach ($result['errors'] as $error) {
                    $this->warn("   - {$error}");
                }
            }
        } else {
            $this->error("❌ Sync failed: {$result['message']}");
            return 1;
        }
        
        // Show final stats
        $this->info('');
        $this->showStats();
        
        return 0;
    }
    
    /**
     * Show sync statistics
     */
    private function showStats()
    {
        $stats = $this->syncService->getSyncStats();
        
        $this->info('Current Statistics:');
        $this->info("   - Taskmaster tasks: {$stats['taskmaster_tasks']}");
        $this->info("   - Database tasks: {$stats['database_tasks']}");
        $this->info("   - In sync: " . ($stats['in_sync'] ? 'Yes ✅' : 'No ❌'));
        $this->info("   - Last sync: " . ($stats['last_sync'] ? $stats['last_sync'] : 'Never'));
    }
} 