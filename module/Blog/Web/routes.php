<?php

/* @var \Illuminate\Routing\Router $router */
// 公共路由，不需要登录
$router->group([], function () use ($router) {
    $router->match(['get'], 'blog', 'IndexController@index');

    $router->match(['get'], 'blog/about', 'AboutController@index');
    $router->match(['get'], 'blog/message', 'MessageController@index');
    $router->match(['get'], 'blog/tags', 'TagsController@index');
    $router->match(['get'], 'blog/archive', 'ArchiveController@index');

    $router->match(['get'], 'blogs', 'BlogController@index');
    $router->match(['get'], 'blog/{id}', 'BlogController@show');
});

// 需要登录的路由
$authMiddleware = [];
if (class_exists(\Module\Member\Middleware\WebAuthMiddleware::class)) {
    $authMiddleware[] = \Module\Member\Middleware\WebAuthMiddleware::class;
}
$router->group([
    'middleware' => $authMiddleware,
], function () use ($router) {
    // 会员博客管理
    $router->match(['get'], 'member_blog', 'MemberBlogController@index');
    $router->match(['get', 'post'], 'member_blog/add', 'MemberBlogController@add');
    $router->match(['get', 'post'], 'member_blog/edit/{id}', 'MemberBlogController@edit');
    $router->match(['post'], 'member_blog/delete', 'MemberBlogController@delete');
    $router->match(['get'], 'member_blog/admin_add', 'MemberBlogController@adminAdd');
});







