<?php

namespace Module\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Module\Blog\Middleware\MemberAdminAuthMiddleware;

class MemberAdminAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 替换 admin.auth 中间件
        // 使用兼容的方法替换中间件
        if (method_exists($this->app['router'], 'aliasMiddleware')) {
            $this->app['router']->aliasMiddleware('admin.auth', MemberAdminAuthMiddleware::class);
        } else {
            // 对于旧版本的 Laravel，使用 middleware 方法
            $this->app['router']->middleware('admin.auth', MemberAdminAuthMiddleware::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
