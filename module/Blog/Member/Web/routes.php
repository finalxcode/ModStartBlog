<?php

/* @var \Illuminate\Routing\Router $router */

// 测试路由
$router->match(['get'], 'blog/member/test', 'TestController@index');

// 登录相关路由
$router->match(['get'], 'blog/member/login', 'AuthController@showLoginForm');
$router->match(['post'], 'blog/member/login', 'AuthController@login');

// 注册相关路由
$router->match(['get'], 'blog/member/register', 'AuthController@showRegisterForm');
$router->match(['post'], 'blog/member/register', 'AuthController@register');

// 验证码
$router->match(['post'], 'blog/member/send-verify-code', 'AuthController@sendVerifyCode');

// 需要登录的路由
$router->group(['middleware' => [\Module\Blog\Member\Middleware\WebAuthMiddleware::class]], function () use ($router) {
    $router->match(['get'], 'blog/member/logout', 'AuthController@logout');
});
