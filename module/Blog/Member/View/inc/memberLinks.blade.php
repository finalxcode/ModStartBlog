<div class="ub-content-box margin-bottom">
    <div class="tw-p-3">
        <div class="tw-text-lg">
            <i class="iconfont icon-user"></i>
            会员中心
        </div>
        <div class="tw-mt-4">
            <div class="row">
                @if(\Module\Member\Auth\MemberUser::isLogin())
                    <div class="col-6">
                        <a href="{{modstart_web_url('member_profile')}}" class="btn btn-round btn-block">
                            <i class="iconfont icon-user"></i>
                            个人中心
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{modstart_web_url('blog/member/logout')}}" class="btn btn-round btn-block">
                            <i class="iconfont icon-exit"></i>
                            退出登录
                        </a>
                    </div>
                @else
                    <div class="col-6">
                        <a href="{{modstart_web_url('blog/member/login')}}" class="btn btn-round btn-block">
                            <i class="iconfont icon-login"></i>
                            登录
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{modstart_web_url('blog/member/register')}}" class="btn btn-round btn-block">
                            <i class="iconfont icon-user-add"></i>
                            注册
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
