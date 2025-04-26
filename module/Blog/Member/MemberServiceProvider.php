<?php

namespace Module\Blog\Member;

use Illuminate\Support\ServiceProvider;
use Module\Blog\Member\Auth\MemberUser;

class MemberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/View', 'blog.member');

        // 为了兼容性，我们也注册一个blog::member前缀
        $this->app['view']->addNamespace('blog', base_path('module/Blog'));

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // 添加视图合成器，在所有视图中添加会员登录状态
        $this->app['view']->composer('*', function ($view) {
            $view->with('memberLoginLinks', view('blog.member::inc.headerLinks')->render());
        });
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        // 注册服务
    }
}
