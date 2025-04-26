<?php
/* @var \Illuminate\Routing\Router $router */
// 公共路由，不需要登录
$router->group([], function () use ($router) {

    $router->match(['get'], 'site/contact', 'SiteController@contact');

});

// 需要登录的路由
$authMiddlewares = [];
if (class_exists(\Module\Blog\Member\Middleware\WebAuthMiddleware::class)) {
    $authMiddlewares[] = \Module\Blog\Member\Middleware\WebAuthMiddleware::class;
}
$router->group([
    'middleware' => $authMiddlewares,
], function () use ($router) {
    // 这里添加需要登录才能访问的路由
});


