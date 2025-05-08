@extends($_viewFrame)

@section('pageTitleMain')注册@endsection
@section('pageKeywords')注册@endsection
@section('pageDescription')注册@endsection

@section('headAppend')
    @parent
    <link rel="canonical" href="{{modstart_web_url('register')}}"/>
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberRegisterPageHeadAppend'); !!}
@endsection

@section('bodyAppend')
    @parent
    {{\ModStart\ModStart::js('asset/common/commonVerify.js')}}
    {{\ModStart\ModStart::js('vendor/Member/entry/register.js')}}
    <script>
        $(function () {
            // 注册类型切换
            $('.register-type-item').click(function(){
                $('.register-type-item').removeClass('active');
                $(this).addClass('active');
                $('.register-form').hide();
                $('.register-form[data-type="'+$(this).data('type')+'"]').show();
            });

            // 运动标签选择
            $('.sports-tags .tag').click(function(e){
                e.preventDefault();
                var checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
                $(this).toggleClass('active');
            });
            
            // 邮箱验证码
            new window.api.commonVerify({
                generateServer: '{{$__msRoot}}register/email_verify',
                selectorTarget: 'input[name=email]',
                selectorGenerate: '[data-email-verify-generate]',
                selectorCountdown: '[data-email-verify-countdown]',
                selectorRegenerate: '[data-email-verify-regenerate]',
                @if(!\Module\Member\Util\SecurityUtil::registerCaptchaProvider())
                selectorCaptcha: 'input[name=captcha]',
                selectorCaptchaImg:'[data-none]',
                @endif
                interval: 60,
                validateOnBlur: false // 禁用失去焦点时验证
            },window.api.dialog);

            // 手机验证码
            new window.api.commonVerify({
                generateServer: '{{$__msRoot}}register/phone_verify',
                selectorTarget: 'input[name=phone]',
                selectorGenerate: '[data-phone-verify-generate]',
                selectorCountdown: '[data-phone-verify-countdown]',
                selectorRegenerate: '[data-phone-verify-regenerate]',
                @if(!\Module\Member\Util\SecurityUtil::registerCaptchaProvider())
                selectorCaptcha: 'input[name=captcha]',
                selectorCaptchaImg:'[data-none]',
                @endif
                interval: 60,
                validateOnBlur: false // 禁用失去焦点时验证
            },window.api.dialog);

            // 表单提交前验证
            $('form[data-ajax-form]').on('submit', function(e) {
                var form = $(this);
                var captcha = form.find('input[name=captcha]');
                if (captcha.length && !captcha.val()) {
                    e.preventDefault();
                    window.api.dialog.tip('请输入验证码');
                    return false;
                }
                return true;
            });
        });
    </script>
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberRegisterPageBodyAppend'); !!}
@endsection

@section('bodyContent')
    <div class="ub-account" style="min-height:calc( 100vh - 220px );">
        <div class="box">
            <div class="nav">
                <a href="{{$__msRoot}}login?redirect={{!empty($redirect)?urlencode($redirect):''}}">登录</a>
                ·
                <a href="javascript:;" class="active">注册</a>
            </div>

            @if(!empty($registerPageTitle))
                {!! $registerPageTitle !!}
            @endif

            <div class="register-type">
                <div class="register-type-item active" data-type="personal">
                    <i class="iconfont icon-user"></i>
                    <div class="title">个人注册</div>
                    <div class="desc">普通用户注册</div>
                </div>
                <div class="register-type-item" data-type="expert">
                    <i class="iconfont icon-star"></i>
                    <div class="title">大神入驻</div>
                    <div class="desc">专业创作者注册</div>
                </div>
                <div class="register-type-item" data-type="enterprise">
                    <i class="iconfont icon-star"></i>
                    <div class="title">企业注册</div>
                    <div class="desc">企业用户注册</div>
                </div>
            </div>

            <div class="ub-form flat">
                <!-- 个人注册表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form class="register-form" data-type="personal">
                    <input type="hidden" name="registerType" value="personal">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="username" placeholder="用户名" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="passwordRepeat" placeholder="重复密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="sports-tags">
                                <div class="sports-tags-title">选择自己喜欢的运动</div>
                                <div class="tags">
                                    <label class="tag"><input type="checkbox" name="sports[]" value="road_running"><span>路跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="marathon"><span>马拉松</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="trail_running"><span>越野跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="hiking"><span>徒步</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="mountaineering"><span>登山</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="rock_climbing"><span>攀岩</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_climbing"><span>攀冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="cycling"><span>骑行</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="roller_skating"><span>轮滑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="downhill"><span>速降</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="bungee_jumping"><span>蹦极</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="skiing"><span>滑雪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_skating"><span>滑冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="shooting"><span>射击</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="swimming"><span>游泳</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="kayaking"><span>皮划艇</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="diving"><span>潜水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="water_skiing"><span>滑水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="sailing"><span>帆船</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="paddleboarding"><span>浆板</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="surfing"><span>冲浪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="golf"><span>高尔夫</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="badminton"><span>羽毛球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="table_tennis"><span>乒乓球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="basketball"><span>篮球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="football"><span>足球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="tennis"><span>网球</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('module::Member.View.pc.inc.registerCaptcha')
                    @if(modstart_config('registerPhoneEnable'))
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="phone" placeholder="输入手机" />
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
                                <input type="text" class="form-lg" name="phoneVerify" placeholder="手机验证码" />
                            </div>
                        </div>
                    @endif
                    @if(modstart_config('registerEmailEnable'))
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="email" placeholder="输入邮箱" />
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-round btn-lg btn-block" type="button" data-email-verify-generate>获取验证码</button>
                                        <button class="btn btn-round btn-lg btn-block" type="button" data-email-verify-countdown style="display:none;margin:0;"></button>
                                        <button class="btn btn-round btn-lg btn-block" type="button" data-email-verify-regenerate style="display:none;margin:0;">重新获取</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line">
                            <div class="field">
                                <input type="text" class="form-lg" name="emailVerify" placeholder="邮箱验证码" />
                            </div>
                        </div>
                    @endif
                    @foreach(\Module\Member\Provider\RegisterProcessor\MemberRegisterProcessorProvider::listAll() as $provider)
                        {!! $provider->render() !!}
                    @endforeach
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">提交注册</button>
                        </div>
                    </div>
                </form>

                <!-- 大神入驻表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form class="register-form" data-type="expert" style="display:none;">
                    <input type="hidden" name="registerType" value="expert">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="username" placeholder="用户名" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="realName" placeholder="真实姓名" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="expertise" placeholder="专业领域" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <textarea class="form-lg" name="introduction" placeholder="个人简介" rows="3"></textarea>
                        </div>
                    </div>
                    @include('module::Member.View.pc.inc.registerCaptcha')
                    @if(modstart_config('registerPhoneEnable'))
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="phone" placeholder="输入手机" />
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
                                <input type="text" class="form-lg" name="phoneVerify" placeholder="手机验证码" />
                            </div>
                        </div>
                    @endif
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="passwordRepeat" placeholder="重复密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="sports-tags">
                                <div class="sports-tags-title">选择自己喜欢的运动</div>
                                <div class="tags">
                                    <label class="tag"><input type="checkbox" name="sports[]" value="road_running"><span>路跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="marathon"><span>马拉松</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="trail_running"><span>越野跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="hiking"><span>徒步</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="mountaineering"><span>登山</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="rock_climbing"><span>攀岩</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_climbing"><span>攀冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="cycling"><span>骑行</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="roller_skating"><span>轮滑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="downhill"><span>速降</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="bungee_jumping"><span>蹦极</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="skiing"><span>滑雪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_skating"><span>滑冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="shooting"><span>射击</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="swimming"><span>游泳</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="kayaking"><span>皮划艇</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="diving"><span>潜水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="water_skiing"><span>滑水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="sailing"><span>帆船</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="paddleboarding"><span>浆板</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="surfing"><span>冲浪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="golf"><span>高尔夫</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="badminton"><span>羽毛球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="table_tennis"><span>乒乓球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="basketball"><span>篮球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="football"><span>足球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="tennis"><span>网球</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach(\Module\Member\Provider\RegisterProcessor\MemberRegisterProcessorProvider::listAll() as $provider)
                        {!! $provider->render() !!}
                    @endforeach
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">提交注册</button>
                        </div>
                    </div>
                </form>

                <!-- 企业注册表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form class="register-form" data-type="enterprise" style="display:none;">
                    <input type="hidden" name="registerType" value="enterprise">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="companyName" placeholder="企业名称" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="businessLicense" placeholder="营业执照号" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="contactName" placeholder="联系人姓名" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="contactPosition" placeholder="联系人职位" />
                        </div>
                    </div>
                    @include('module::Member.View.pc.inc.registerCaptcha')
                    @if(modstart_config('registerPhoneEnable'))
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="phone" placeholder="输入手机" />
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
                                <input type="text" class="form-lg" name="phoneVerify" placeholder="手机验证码" />
                            </div>
                        </div>
                    @endif
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="passwordRepeat" placeholder="重复密码" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="sports-tags">
                                <div class="sports-tags-title">选择自己喜欢的运动</div>
                                <div class="tags">
                                    <label class="tag"><input type="checkbox" name="sports[]" value="road_running"><span>路跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="marathon"><span>马拉松</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="trail_running"><span>越野跑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="hiking"><span>徒步</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="mountaineering"><span>登山</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="rock_climbing"><span>攀岩</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_climbing"><span>攀冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="cycling"><span>骑行</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="roller_skating"><span>轮滑</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="downhill"><span>速降</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="bungee_jumping"><span>蹦极</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="skiing"><span>滑雪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="ice_skating"><span>滑冰</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="shooting"><span>射击</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="swimming"><span>游泳</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="kayaking"><span>皮划艇</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="diving"><span>潜水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="water_skiing"><span>滑水</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="sailing"><span>帆船</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="paddleboarding"><span>浆板</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="surfing"><span>冲浪</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="golf"><span>高尔夫</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="badminton"><span>羽毛球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="table_tennis"><span>乒乓球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="basketball"><span>篮球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="football"><span>足球</span></label>
                                    <label class="tag"><input type="checkbox" name="sports[]" value="tennis"><span>网球</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach(\Module\Member\Provider\RegisterProcessor\MemberRegisterProcessorProvider::listAll() as $provider)
                        {!! $provider->render() !!}
                    @endforeach
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">提交注册</button>
                        </div>
                    </div>
                </form>

                @if(modstart_config('Member_AgreementEnable',false)||modstart_config('Member_PrivacyEnable',false))
                    <div class="line">
                        <div class="field">
                            <input type="checkbox" name="agreement" value="1" checked class="tw-align-middle" />
                            @if(modstart_config('Member_AgreementEnable',false))
                                <a href="{{modstart_web_url('member/agreement')}}" target="_blank">{{modstart_config('Member_AgreementTitle','用户使用协议')}}</a>
                            @endif
                            @if(modstart_config('Member_PrivacyEnable',false))
                                <a href="{{modstart_web_url('member/privacy')}}" target="_blank">{{modstart_config('Member_PrivacyTitle','用户隐私协议')}}</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .register-type {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            padding: 0 20px;
        }
        .register-type-item {
            flex: 1;
            text-align: center;
            padding: 20px;
            margin: 0 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .register-type-item:hover {
            border-color: #007bff;
        }
        .register-type-item.active {
            border-color: #007bff;
            background: #f8f9fa;
        }
        .register-type-item .iconfont {
            font-size: 32px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .register-type-item .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .register-type-item .desc {
            font-size: 12px;
            color: #666;
        }

        /* 运动标签样式 */
        .sports-tags {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .sports-tags-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            color: #666;
            position: relative;
        }
        .tag:hover {
            border-color: #007bff;
            color: #007bff;
        }
        .tag.active {
            background: #e6f3ff;
            color: #007bff;
            border-color: #007bff;
        }
        .tag input[type="checkbox"] {
            display: none;
        }
        .tag.active::after {
            content: '';
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background: #007bff;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .tag.active span {
            padding-right: 24px;
        }
    </style>
@endsection
