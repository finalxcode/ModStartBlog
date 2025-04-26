<?php

namespace Module\Blog\Member\Middleware;

use Closure;
use Module\Blog\Member\Auth\MemberUser;

class WebAuthMiddleware
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
        if (!MemberUser::isLogin()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => '请先登录'], 401);
            }
            return redirect(modstart_web_url('blog/member/login'));
        }
        return $next($request);
    }
}
