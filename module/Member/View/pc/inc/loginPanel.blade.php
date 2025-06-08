<div class="ub-account" style="min-height:calc( 100vh - 220px );">
    <div class="box">
        <div class="nav">
            <a href="javascript:;" class="active">账号登录</a>
            @if(modstart_config('Member_LoginPhoneEnable',false))
                ·
                <a href="{{modstart_web_url('login/phone',['redirect'=>empty($redirect)?null:$redirect])}}">手机登录</a>
            @endif
            @if(!modstart_config('registerDisable',false))
                ·
                <a href="{{$__msRoot}}register?redirect={{!empty($redirect)?urlencode($redirect):''}}">注册</a>
            @endif
        </div>
        <div class="ub-form flat">
            <form action="{{modstart_web_url('login')}}" method="post" data-ajax-form class="login-form">
                @if(modstart_config('Member_LoginInfoEncrypt',false))
                    <input type="hidden" data-encrypt-data name="ek" value="{{\ModStart\Core\Util\RandomUtil::string(8)}}" />
                @endif
                <div class="line">
                    <div class="field">
                        <input type="text" class="form-lg" name="username" placeholder="输入用户"
                               @if(modstart_config('Member_LoginInfoEncrypt',false)) data-encrypt-field="username" @endif/>
                    </div>
                </div>
                <div class="line">
                    <div class="field">
                        <input type="password" class="form-lg" name="password" placeholder="输入密码"
                               @if(modstart_config('Member_LoginInfoEncrypt',false)) data-encrypt-field="password" @endif/>
                    </div>
                </div>
                @if(modstart_config('loginCaptchaEnable',false))
                    @if($provider = \Module\Member\Util\SecurityUtil::loginCaptchaProvider())
                        <div style="padding:0.5rem;">
                            {!! $provider->render() !!}
                        </div>
                    @else
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="captcha" autocomplete="off" placeholder="图片验证码" />
                                    </div>
                                    <div class="col-5">
                                        <img class="captcha captcha-lg" title="刷新验证" data-captcha
                                             src="{{modstart_web_url('login/captcha')}}"
                                             onclick="$(this).attr('src','{{modstart_web_url('login/captcha')}}?'+Math.random())" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="line">
                    <div class="field">
                        <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">登录</button>
                        <input type="hidden" name="redirect" value="{{empty($redirect)?'':$redirect}}">
                    </div>
                </div>
            </form>
        </div>

        @include('module::Member.View.pc.oauthButtons')

        @if(!modstart_config('retrieveDisable',false))
            <div class="retrieve">
                忘记密码?
                <a target="_parent" href="{{modstart_web_url('retrieve',['redirect'=>empty($redirect)?null:$redirect])}}">找回密码</a>
            </div>
        @endif
    </div>
</div>

<style>
    /* 基础表单样式 */
    .login-form {
        max-width: 800px;
        margin: 0 auto;
    }
    
    /* 表单项容器 */
    .line {
        margin-bottom: 20px;
    }
    
    /* 输入框样式 */
    .form-lg {
        width: 100%;
        height: 40px;
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #dcdee2;
        border-radius: 4px;
        transition: all .3s;
        background: #fff;
    }
    
    .form-lg:hover {
        border-color: #57a3f3;
    }
    
    .form-lg:focus {
        border-color: #57a3f3;
        outline: none;
        box-shadow: 0 0 0 2px rgba(45,140,240,.2);
    }
    
    /* 按钮样式优化 */
    .btn-block {
        width: 200px;
        margin: 0 auto;
        display: block;
    }
    
    /* 按钮容器居中 */
    .login-form .line:has(button[type="submit"]) .field {
        text-align: center;
    }
    
    /* 验证码图片样式 */
    .captcha {
        border: 1px solid #dcdee2;
        border-radius: 4px;
        cursor: pointer;
        transition: all .3s;
    }
    
    .captcha:hover {
        border-color: #57a3f3;
    }
    
    /* 找回密码链接样式 */
    .retrieve {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }
    
    .retrieve a {
        color: #007bff;
        text-decoration: none;
        margin-left: 5px;
    }
    
    .retrieve a:hover {
        text-decoration: underline;
    }
    
    /* 导航样式优化 */
    .nav {
        text-align: center;
        margin-bottom: 30px;
        font-size: 16px;
    }
    
    .nav a {
        color: #666;
        text-decoration: none;
        padding: 0 10px;
        transition: all .3s;
    }
    
    .nav a:hover,
    .nav a.active {
        color: #007bff;
    }
    
    /* OAuth按钮区域样式 */
    .oauth-buttons {
        margin-top: 30px;
    }
    
    /* 整体容器样式 */
    .ub-account {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .ub-account .box {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 40px;
        width: 100%;
        max-width: 500px;
    }
    
    /* 响应式设计 */
    @media (max-width: 768px) {
        .ub-account .box {
            padding: 30px 20px;
            margin: 20px;
        }
        
        .login-form {
            max-width: 100%;
        }
    }
</style>
