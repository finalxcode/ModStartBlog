@if(modstart_module_enabled('Member') && \Module\Member\Auth\MemberUser::isLogin())
    <div class="ub-content-box margin-bottom">
        <div class="tw-p-3">
            <div class="tw-text-lg">
                <i class="iconfont icon-user-o"></i>
                会员专区
            </div>
            <div class="tw-mt-4">
                <div class="row">
                    <div class="col-6">
                        <a href="javascript:;" class="btn btn-round btn-block"
                           data-dialog-width="90%" data-dialog-height="90%"
                           data-dialog-request="{{modstart_admin_url('blog/blog/add',['from'=>'front','memberUserId'=>\Module\Member\Auth\MemberUser::id()])}}"
                        >
                            <i class="iconfont icon-plus"></i>
                            发布博客
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{modstart_web_url('member')}}" class="btn btn-round btn-block">
                            <i class="iconfont icon-user"></i>
                            会员中心
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
