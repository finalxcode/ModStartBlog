<?php

namespace Module\Member\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Member\Config\MemberOauth;

class OauthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 不注册任何第三方登录提供者
        MemberOauth::register([]);
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
