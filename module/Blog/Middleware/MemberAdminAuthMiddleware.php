<?php

namespace Module\Blog\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use ModStart\Admin\Auth\Admin;
use ModStart\Admin\Middleware\AuthMiddleware;
use ModStart\Core\Input\Request;
use ModStart\Core\Input\Response;
use Module\Member\Auth\MemberUser;

class MemberAdminAuthMiddleware extends AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果是会员，并且是访问博客发布页面，允许通过
        if (MemberUser::isLogin()) {
            $path = $request->path();
            if (strpos($path, 'admin/blog/blog/add') !== false || strpos($path, 'admin/blog/blog/edit') !== false) {
                // 创建一个临时的 Admin 会话，用于访问 Admin 的博客发布页面
                $adminUserId = 1; // 假设 ID 为 1 的管理员是超级管理员
                $adminUser = Admin::get($adminUserId);
                if (empty($adminUser)) {
                    return Response::send(-1, '管理员不存在');
                }

                // 设置 Admin 会话
                Session::put('_adminUserId', $adminUserId);
                Session::flash('_adminUser', $adminUser);

                return $next($request);
            }
        }

        // 如果不是会员访问博客发布页面，则使用父类的处理方法
        return parent::handle($request, $next);
    }
}
