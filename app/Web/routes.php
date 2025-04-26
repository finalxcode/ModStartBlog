<?php
// 公共路由，不需要登录
Route::group(
    [
        'middleware' => ['web.bootstrap'],
        'namespace' => '\App\Web\Controller',
    ], function () {

    Route::match(['get', 'post'], '', 'IndexController@index');
});

// 需要登录的路由
$authMiddlewares = [
    'web.bootstrap'
];
if (class_exists(\Module\Blog\Member\Middleware\WebAuthMiddleware::class)) {
    $authMiddlewares[] = \Module\Blog\Member\Middleware\WebAuthMiddleware::class;
}
Route::group(
    [
        'middleware' => $authMiddlewares,
        'namespace' => '\App\Web\Controller',
    ], function () {

    Route::match(['get', 'post'], 'member/{id}', 'MemberController@show');
    Route::match(['get', 'post'], 'member_profile', 'MemberProfileController@index');

});
