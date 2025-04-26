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
if (class_exists(\Module\Blog\Member\Middleware\WebAuthMiddleware::class)) {
    $authMiddleware[] = \Module\Blog\Member\Middleware\WebAuthMiddleware::class;
}
$router->group([
    'middleware' => $authMiddleware,
], function () use ($router) {
    // 这里添加需要登录才能访问的路由
});







