<?php

use Illuminate\Support\Facades\Route;
use Module\Blog\Member\Controller\AuthController;
use Module\Blog\Member\Controller\IndexController;

// 首页路由已在其他地方注册

// 测试路由
Route::get('blog/member/test', [\Module\Blog\Member\Controller\TestController::class, 'index']);

// 登录相关路由
Route::get('blog/member/login', [AuthController::class, 'showLoginForm'])->name('blog.member.login');
Route::post('blog/member/login', [AuthController::class, 'login']);

// 注册相关路由
Route::get('blog/member/register', [AuthController::class, 'showRegisterForm'])->name('blog.member.register');
Route::post('blog/member/register', [AuthController::class, 'register']);

// 验证码
Route::post('blog/member/send-verify-code', [AuthController::class, 'sendVerifyCode']);

// 需要登录的路由
Route::group(['middleware' => [\Module\Blog\Member\Middleware\WebAuthMiddleware::class]], function () {
    Route::get('blog/member/logout', [AuthController::class, 'logout'])->name('blog.member.logout');
});
