<?php

namespace Module\Blog\Member\Controller;

use Illuminate\Routing\Controller;
use ModStart\Core\Input\Response;
use Module\Blog\Web\Controller\IndexController as BlogIndexController;

class IndexController extends Controller
{
    public function index()
    {
        // 获取原始的博客首页内容
        $blogController = app(BlogIndexController::class);
        $response = $blogController->index();
        
        // 如果是视图响应，我们添加会员登录链接
        if ($response instanceof \Illuminate\View\View) {
            $memberLinks = view('blog.member::inc.memberLinks')->render();
            $response->with('memberLinks', $memberLinks);
        }
        
        return $response;
    }
}
