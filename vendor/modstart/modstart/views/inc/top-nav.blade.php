<div class="ub-top-nav">
    <div class="ub-container">
        <div class="left">
            欢迎访问的运动圈
        </div>
        <div class="right">
            <a href="{{modstart_web_url('login')}}">请 注册|登录</a>
            <a href="{{modstart_web_url('new-user')}}" class="new-user">
                <i class="iconfont icon-gift"></i>
                新人专享
            </a>
            <a href="{{modstart_web_url('share')}}">分享交流</a>
        </div>
    </div>
</div>

<style type="text/css">
.ub-top-nav {
    background: #fff;
    border-bottom: 1px solid #eee;
    height: 36px;
    line-height: 36px;
    font-size: 12px;
    color: #666;
    position: relative;
    z-index: 999;
}

.ub-top-nav .ub-container {
    width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
}

.ub-top-nav .right a {
    color: #666;
    text-decoration: none;
    margin-left: 20px;
    display: inline-block;
}

.ub-top-nav .right a:hover {
    color: #f60;
}

.ub-top-nav .right .new-user {
    color: #f60;
}

.ub-top-nav .right .new-user .iconfont {
    font-size: 14px;
    margin-right: 5px;
}
</style> 