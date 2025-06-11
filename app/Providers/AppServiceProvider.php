<?php

namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use App\Services\TaskmasterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register TaskmasterService as singleton
        $this->app->singleton(TaskmasterService::class, function ($app) {
            return new TaskmasterService();
        });
        
        // Register TaskDatabaseSync service
        $this->app->singleton('App\Services\TaskDatabaseSync', function ($app) {
            return new \App\Services\TaskDatabaseSync($app->make(TaskmasterService::class));
        });
    }
}
