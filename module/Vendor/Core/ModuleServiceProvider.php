<?php

namespace Module\Vendor\Core;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Module\Vendor\Command\CompressDirImage;
use Module\Vendor\Command\ScheduleRunAllCommand;
use Module\Vendor\Command\ScheduleRunnerCommand;
use Module\Vendor\Provider\Schedule\ScheduleBiz;
use Module\Vendor\Provider\SmsSender\DebugSmsSenderProvider;
use Module\Vendor\Provider\SmsSender\SmsSenderProvider;
use Module\Vendor\Schedule\DataTempCleanScheduleBiz;
use Module\Vendor\Schedule\TempFileCleanScheduleBiz;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $this->commands([
            ScheduleRunnerCommand::class,
            ScheduleRunAllCommand::class,
            CompressDirImage::class,
        ]);
        if (class_exists(DataTempCleanScheduleBiz::class)) {
            ScheduleBiz::register(DataTempCleanScheduleBiz::class);
            ScheduleBiz::register(TempFileCleanScheduleBiz::class);
        }
        
        // 注册调试短信发送服务
        SmsSenderProvider::register(DebugSmsSenderProvider::class);
        
        // 设置默认的短信发送服务提供商（如果未配置）
        $this->setDefaultSmsSenderProvider();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
    
    /**
     * 设置默认的短信发送服务提供商
     */
    private function setDefaultSmsSenderProvider()
    {
        $provider = config('SmsSenderProvider');
        if (empty($provider)) {
            // 如果没有配置短信发送服务，默认使用调试模式
            config(['SmsSenderProvider' => 'debug']);
        }
    }
}
