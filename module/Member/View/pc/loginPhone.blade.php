@extends($_viewFrame)

@section('pageTitleMain')短信验证登录@endsection
@section('pageKeywords')短信验证登录@endsection
@section('pageDescription')短信验证登录@endsection

@section('headAppend')
    @parent
    <link rel="canonical" href="{{modstart_web_url('login/phone')}}"/>
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberLoginPageHeadAppend'); !!}
@endsection

@section('bodyAppend')
    @parent
    {{\ModStart\ModStart::js('asset/common/commonVerify.js')}}
    <script>
        $(function () {
            new window.api.commonVerify({
                generateServer: '{{$__msRoot}}login/phone_verify',
                selectorTarget: 'input[name=phone]',
                selectorGenerate: '[data-phone-verify-generate]',
                selectorCountdown: '[data-phone-verify-countdown]',
                selectorRegenerate: '[data-phone-verify-regenerate]',
                @if(!\Module\Member\Util\SecurityUtil::loginCaptchaProvider())
                    selectorCaptcha: 'input[name=captcha]',
                    selectorCaptchaImg:'img[data-captcha]',
                @endif
                interval: 60,
                formData:function(){
                    var $provider = $('[data-captcha-provider]');
                    var data = {};
                    $provider.find('input').each(function () {
                        var $this = $(this);
                        data[$this.attr('name')] = $this.val();
                    });
                    return data;
                }
            },window.api.dialog);
        });
    </script>
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberLoginPageBodyAppend'); !!}
@endsection


@section('bodyContent')
    <div class="ub-account" style="min-height:calc( 100vh - 220px );">
        <div class="box">
            <div class="nav">
                <a href="{{modstart_web_url('login',['redirect'=>empty($redirect)?null:$redirect])}}">账号登录</a>
                ·
                <a href="javascript:;" class="active">手机登录</a>
                @if(!modstart_config('registerDisable',false) && !modstart_config('Member_LoginPhoneAutoRegister', false))
                    ·
                    <a href="{{$__msRoot}}register?redirect={{!empty($redirect)?urlencode($redirect):''}}">注册</a>
                @endif
            </div>

            <div class="ub-form flat">
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form class="login-form">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="phone" placeholder="输入手机" />
                        </div>
                    </div>
                    @if($provider=\Module\Member\Util\SecurityUtil::loginCaptchaProvider())
                        <div style="padding:0.5rem;" data-captcha-provider>
                            <div>
                                {!! $provider->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-10">
                                        <input type="text" class="form-lg" name="captcha" autocomplete="off" placeholder="图片验证码" />
                                    </div>
                                    <div class="col-2">
                                        <img class="captcha captcha-lg" data-captcha title="刷新验证" onclick="this.src='{{$__msRoot}}login/phone_captcha?'+Math.random()" src="{{$__msRoot}}login/phone_captcha?{{time()}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-7">
                                    <input type="text" class="form-lg" name="verify" placeholder="输入验证码" />
                                </div>
                                <div class="col-5">
                                    <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-generate>获取验证码</button>
                                    <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-countdown style="display:none;margin:0;"></button>
                                    <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-regenerate style="display:none;margin:0;">重新获取</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">登录</button>
                            <input type="hidden" name="redirect" value="{{empty($redirect)?'':$redirect}}">
                            @if(modstart_config('Member_LoginPhoneAutoRegister', false))
                                <div class="ub-text-muted login-note">
                                    未注册的手机号，我们将自动帮您注册账号
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            @include('module::Member.View.pc.oauthButtons')

            @if(!modstart_config('retrieveDisable',false))
                <div class="retrieve">
                    忘记密码?
                    <a target="_parent" href="{{$__msRoot}}retrieve?redirect={{urlencode($redirect)}}">找回密码</a>
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
        
        /* 登录说明文本 */
        .login-note {
            color: #999;
            font-size: 12px;
            margin-top: 15px;
            text-align: center;
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
@endsection
