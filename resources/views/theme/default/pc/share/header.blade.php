<header class="ub-header-b">
    <div class="ub-container">
        <div class="menu">
            <a class="item" href="{{modstart_web_url('blog/member/login')}}">
                <i class="iconfont icon-login"></i>
                登录
            </a>
            <a class="item" href="{{modstart_web_url('blog/member/register')}}">
                <i class="iconfont icon-plus"></i>
                注册
            </a>
        </div>
        <div class="logo">
            <a href="{{modstart_web_url('')}}">
                <img src="{{\ModStart\Core\Assets\AssetsUtil::fix(modstart_config('siteLogo'))}}"/>
            </a>
        </div>
        <div class="nav-mask" onclick="MS.header.hide()"></div>
        <div class="nav">
            @include('module::Vendor.View.searchBox.header')
            {!! \Module\Nav\View\NavView::position('head') !!}
        </div>
        <a class="nav-toggle" href="javascript:;" onclick="MS.header.trigger()">
            <i class="show iconfont icon-list"></i>
            <i class="close iconfont icon-close"></i>
        </a>
    </div>
</header>
