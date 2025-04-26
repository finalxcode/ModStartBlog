<?php

namespace Module\Blog\Web\Controller;

use Illuminate\Routing\Controller;
use ModStart\Core\Dao\ModelUtil;
use ModStart\Core\Exception\BizException;
use ModStart\Core\Input\InputPackage;
use ModStart\Core\Input\Request;
use ModStart\Core\Input\Response;
use ModStart\Core\Util\CRUDUtil;
use ModStart\Module\ModuleBaseController;
use Module\Blog\Model\Blog;
use Module\Blog\Model\BlogCategory;
use Module\Blog\Type\BlogVisitMode;
use Module\Member\Auth\MemberUser;

class MemberBlogController extends ModuleBaseController
{
    public function index()
    {
        if (!MemberUser::isLogin()) {
            return Response::redirect(modstart_web_url('login', ['redirect' => Request::currentPageUrl()]));
        }

        $memberUserId = MemberUser::id();
        $blogs = ModelUtil::model(Blog::class)
            ->where('memberUserId', $memberUserId)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return $this->view('blog.memberBlog.index', [
            'blogs' => $blogs,
            'pageTitle' => '我的博客',
        ]);
    }

    public function add()
    {
        if (!MemberUser::isLogin()) {
            return Response::redirect(modstart_web_url('login', ['redirect' => Request::currentPageUrl()]));
        }

        if (Request::isPost()) {
            $input = InputPackage::buildFromInput();
            $data = [];
            $data['title'] = $input->getTrimString('title');
            BizException::throwsIfEmpty('标题不能为空', $data['title']);
            $data['categoryId'] = $input->getInteger('categoryId');
            $data['content'] = $input->getTrimString('content');
            BizException::throwsIfEmpty('内容不能为空', $data['content']);
            $data['summary'] = $input->getTrimString('summary');
            if (empty($data['summary']) && !empty($data['content'])) {
                $data['summary'] = mb_substr(strip_tags($data['content']), 0, 200);
            }
            $data['tag'] = $input->getTrimString('tag');
            $data['isPublished'] = true;
            $data['postTime'] = date('Y-m-d H:i:s');
            $data['memberUserId'] = MemberUser::id();
            $data['visitMode'] = BlogVisitMode::OPEN;

            ModelUtil::insert('blog', $data);

            return Response::redirect(modstart_web_url('member_blog'));
        }

        $categories = BlogCategory::all();

        return $this->view('blog.memberBlog.add', [
            'categories' => $categories,
            'pageTitle' => '发布博客',
        ]);
    }

    public function edit($id)
    {
        if (!MemberUser::isLogin()) {
            return Response::redirect(modstart_web_url('login', ['redirect' => Request::currentPageUrl()]));
        }

        $memberUserId = MemberUser::id();
        $blog = ModelUtil::get('blog', $id);
        BizException::throwsIfEmpty('博客不存在', $blog);
        BizException::throwsIf('无权限编辑此博客', $blog['memberUserId'] != $memberUserId);

        if (Request::isPost()) {
            $input = InputPackage::buildFromInput();
            $data = [];
            $data['title'] = $input->getTrimString('title');
            BizException::throwsIfEmpty('标题不能为空', $data['title']);
            $data['categoryId'] = $input->getInteger('categoryId');
            $data['content'] = $input->getTrimString('content');
            BizException::throwsIfEmpty('内容不能为空', $data['content']);
            $data['summary'] = $input->getTrimString('summary');
            if (empty($data['summary']) && !empty($data['content'])) {
                $data['summary'] = mb_substr(strip_tags($data['content']), 0, 200);
            }
            $data['tag'] = $input->getTrimString('tag');

            ModelUtil::update('blog', $id, $data);

            return Response::redirect(modstart_web_url('member_blog'));
        }

        $categories = BlogCategory::all();

        return $this->view('blog.memberBlog.edit', [
            'blog' => $blog,
            'categories' => $categories,
            'pageTitle' => '编辑博客',
        ]);
    }

    public function delete()
    {
        if (!MemberUser::isLogin()) {
            return Response::json(-1, '请先登录');
        }

        $id = CRUDUtil::id();
        $memberUserId = MemberUser::id();
        $blog = ModelUtil::get('blog', $id);
        BizException::throwsIfEmpty('博客不存在', $blog);
        BizException::throwsIf('无权限删除此博客', $blog['memberUserId'] != $memberUserId);

        ModelUtil::delete('blog', $id);

        return Response::jsonSuccess('删除成功', null, modstart_web_url('member_blog'));
    }

    public function adminAdd()
    {
        if (!MemberUser::isLogin()) {
            return Response::json(-1, '请先登录');
        }

        // 创建一个临时的 Admin 会话，用于访问 Admin 的博客发布页面
        $adminUserId = 1; // 假设 ID 为 1 的管理员是超级管理员
        $adminUser = \ModStart\Admin\Auth\Admin::get($adminUserId);
        if (empty($adminUser)) {
            return Response::json(-1, '管理员不存在');
        }

        // 保存当前会员 ID
        $memberUserId = MemberUser::id();

        // 设置 Admin 会话
        \Illuminate\Support\Facades\Session::put('_adminUserId', $adminUserId);
        \Illuminate\Support\Facades\Session::flash('_adminUser', $adminUser);

        // 返回 Admin 的博客发布页面的 URL
        $url = modstart_admin_url('blog/blog/add', ['from' => 'front', 'memberUserId' => $memberUserId]);
        return Response::jsonSuccess('', null, null, [
            'code' => 'location.href = ' . json_encode($url),
        ]);
    }
}
