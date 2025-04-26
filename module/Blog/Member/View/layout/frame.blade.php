<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('pageTitle') - {{modstart_config('siteName')}}</title>
    <meta name="keywords" content="@yield('pageKeywords',modstart_config('siteKeywords'))">
    <meta name="description" content="@yield('pageDescription',modstart_config('siteDescription'))">
    <link rel="shortcut icon" href="{{modstart_config('siteFavIco')}}">
    {!! \ModStart\ModStart::css() !!}
    {!! \ModStart\ModStart::style() !!}
    @section('headAppend')@show
    @yield('styles')
</head>
<body>
<div class="ub-header">
    <div class="ub-container">
        <div class="logo">
            <a href="{{modstart_web_url('')}}">
                <img src="{{\ModStart\Core\Assets\AssetsUtil::fix(modstart_config('siteLogo'))}}"/>
            </a>
        </div>
        <div class="menu-mask" onclick="$('body').removeClass('ub-header-show')"></div>
        <div class="menu">
            <a class="item" href="{{modstart_web_url('')}}">首页</a>
            <a class="item" href="{{modstart_web_url('blog')}}">博客</a>
            @if(\Module\Blog\Member\Auth\MemberUser::isLogin())
                <a class="item" href="{{modstart_web_url('member_profile')}}">
                    <i class="iconfont icon-user"></i>
                    {{\Module\Blog\Member\Auth\MemberUser::get('username')}}
                </a>
                <a class="item" href="{{modstart_web_url('blog/member/logout')}}">退出</a>
            @else
                <a class="item" href="{{modstart_web_url('blog/member/login')}}">登录</a>
                <a class="item" href="{{modstart_web_url('blog/member/register')}}">注册</a>
            @endif
        </div>
        <a class="menu-toggle" href="javascript:;" onclick="$('body').toggleClass('ub-header-show')">
            <i class="show iconfont icon-list"></i>
            <i class="close iconfont icon-close"></i>
        </a>
    </div>
</div>

@yield('bodyContent')

<div class="ub-footer">
    <div class="ub-container">
        <div class="line"></div>
        <div class="links">
            <a href="{{modstart_web_url('')}}">首页</a>
            <a href="{{modstart_web_url('blog')}}">博客</a>
            <a href="{{modstart_web_url('blog/about')}}">关于</a>
        </div>
        <div class="copyright">
            {!! modstart_config('siteCopyright') !!}
        </div>
    </div>
</div>

{!! \ModStart\ModStart::js() !!}
{!! \ModStart\ModStart::script() !!}
@section('bodyAppend')@show
</body>
</html>
