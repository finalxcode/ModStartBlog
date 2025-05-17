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
            var needCaptcha = {!! \Module\Member\Util\SecurityUtil::registerCaptchaProvider() ? 'false' : 'true' !!};
            
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
            var emailVerifyOptions = {
                generateServer: '{{$__msRoot}}register/email_verify',
                selectorTarget: 'input[name=email]',
                selectorGenerate: '[data-email-verify-generate]',
                selectorCountdown: '[data-email-verify-countdown]',
                selectorRegenerate: '[data-email-verify-regenerate]',
                interval: 60,
                validateOnBlur: false,
                validateOnChange: false,
                validateOnInput: false,
                validateOnKeyup: false,
                validateOnGenerate: false,
                validateOnSubmit: true
            };
            
            if (needCaptcha) {
                emailVerifyOptions.selectorCaptcha = 'input[name=captcha]';
                emailVerifyOptions.selectorCaptchaImg = '[data-captcha-img]';
            }
            
            new window.api.commonVerify(emailVerifyOptions);

            // 手机验证码
            var phoneVerifyOptions = {
                generateServer: '{{$__msRoot}}register/phone_verify',
                selectorTarget: 'input[name=phone]',
                selectorGenerate: '[data-phone-verify-generate]',
                selectorCountdown: '[data-phone-verify-countdown]',
                selectorRegenerate: '[data-phone-verify-regenerate]',
                interval: 60,
                validateOnBlur: false,
                validateOnChange: false,
                validateOnInput: false,
                validateOnKeyup: false,
                validateOnGenerate: false,
                validateOnSubmit: true
            };
            
            if (needCaptcha) {
                phoneVerifyOptions.selectorCaptcha = 'input[name=captcha]';
                phoneVerifyOptions.selectorCaptchaImg = '[data-captcha-img]';
            }
            
            new window.api.commonVerify(phoneVerifyOptions);

            // 移除所有输入框的验证事件监听
            $('input[name=email], input[name=phone], input[name=captcha]').off('blur change input keyup');
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
                    
                    <div class="expert-welcome">
                        <h3>欢迎大神来到运动圈！</h3>
                        <p>运动圈通过展会数万观众、自媒体、视频号、搜索引擎、B2B平台、网络媒体等大量引流，您将被更多人关注。如您某项运动成绩符合以下入库标准，请选择自己喜欢的内容并入驻相应大神库，这将有助于你成功入驻上手使用运动圈社区 ^_^</p>
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

                    <div class="line">
                        <div class="field">
                            <div class="expert-database">
                                <div class="expert-database-title">选择您要录入的大神库</div>
                                <div class="expert-database-list">
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="marathon_sub3">
                                        <span>中国马拉松破三跑者库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="ultra_100k">
                                        <span>中国百公里越野赛跑者库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="cycling_level3">
                                        <span>达到国家三级运动员水平骑者库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="roller_level3">
                                        <span>达到国家三级运动员标准轮滑大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="downhill_level3">
                                        <span>达到国家三级运动员标准速降大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="mountaineering_level3">
                                        <span>达到国家三级运动员标准登山大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="rock_climbing_level3">
                                        <span>达到国家三级运动员标准攀岩大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="swimming_level3">
                                        <span>达到国家三级运动员标准游泳大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="kayaking_level3">
                                        <span>达到国家三级运动员标准皮划艇大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="diving_level3">
                                        <span>达到国家三级运动员标准潜水大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="ice_climbing_level3">
                                        <span>达到国家三级运动员标准攀冰大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="skiing_level3">
                                        <span>达到国家三级运动员标准滑雪大神库</span>
                                    </label>
                                    <label class="database-item">
                                        <input type="checkbox" name="expert_database[]" value="ice_skating_level3">
                                        <span>达到国家三级运动员标准滑冰大神库</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <div class="certificate-upload">
                                <div class="certificate-title">上传您的证书</div>
                                <div class="upload-area">
                                    <input type="file" name="certificate" accept="image/*,.pdf" class="certificate-input" />
                                    <div class="upload-tip">支持jpg、png、pdf格式，大小不超过10MB</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="realName" placeholder="姓名（必填）" required />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="email" class="form-lg" name="email" placeholder="常用邮箱（必填）" required style="width: 100%;" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="location" placeholder="所在地区（必填）" required />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="contactName" placeholder="联系信息（姓名须与证书一致）" required />
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
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" required />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="passwordRepeat" placeholder="重复密码" required />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">提交注册</button>
                        </div>
                    </div>
                </form>

                <!-- 企业注册表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form class="register-form" data-type="enterprise" style="display:none;">
                    <input type="hidden" name="registerType" value="enterprise">
                    
                    <div class="form-group">
                        <div class="form-group-title">填写账号信息</div>
                        <div class="form-group-subtitle">注："*"为必填项</div>
                        
                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>企业类型</label>
                                <div class="field-content">
                                    <select class="form-lg" name="companyType" required>
                                        <option value="">请选择企业类型</option>
                                        <option value="sports_store">运动器材及用品店</option>
                                        <option value="manufacturer">生产商</option>
                                        <option value="branch">分公司</option>
                                        <option value="office">代表处</option>
                                        <option value="agent">代理商</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>用户名</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="username" required />
                                    <div class="field-help">不支持汉字，不能以数字开头；建议使用公司名的字母缩写</div>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>登录密码</label>
                                <div class="field-content">
                                    <input type="password" class="form-lg" name="password" required />
                                    <div class="field-help">密码由6-20个英文字母（区分大小写）或数字组成</div>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>确认密码</label>
                                <div class="field-content">
                                    <input type="password" class="form-lg" name="passwordRepeat" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group-title">公司基本信息</div>
                        <div class="form-group-subtitle">含个体工商户，请认真地填写以下信息，严肃的商业信息有助于您获得别人的信任！</div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>企业名称</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="companyName" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>所在地区</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="location" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>企业规模</label>
                                <div class="field-content">
                                    <select class="form-lg" name="companySize" required>
                                        <option value="">请选择企业规模</option>
                                        <option value="1-10">1-10人</option>
                                        <option value="11-50">11-50人</option>
                                        <option value="51-200">51-200人</option>
                                        <option value="201-500">201-500人</option>
                                        <option value="501-1000">501-1000人</option>
                                        <option value="1000+">1000人以上</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>营业额</label>
                                <div class="field-content">
                                    <select class="form-lg" name="revenue" required>
                                        <option value="">请选择年营业额</option>
                                        <option value="0-100">100万以下</option>
                                        <option value="100-500">100-500万</option>
                                        <option value="500-1000">500-1000万</option>
                                        <option value="1000-5000">1000-5000万</option>
                                        <option value="5000+">5000万以上</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label>企业简介</label>
                                <div class="field-content">
                                    <textarea class="form-lg" name="companyDescription" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group-title">联系信息</div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>联系人</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="contactName" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>职位</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="contactPosition" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>电话</label>
                                <div class="field-content">
                                    <input type="tel" class="form-lg" name="telephone" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>手机</label>
                                <div class="field-content">
                                    <input type="tel" class="form-lg" name="phone" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>邮编</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="zipCode" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>通讯地址</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="address" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>常用邮箱</label>
                                <div class="field-content">
                                    <input type="email" class="form-lg" name="email" required />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>公司网址</label>
                                <div class="field-content">
                                    <input type="url" class="form-lg" name="website" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('module::Member.View.pc.inc.registerCaptcha')
                    @if(modstart_config('registerPhoneEnable'))
                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>手机验证码</label>
                                <div class="field-content captcha-group">
                                    <input type="text" class="form-lg" name="phoneVerify" required />
                                    <button class="btn btn-round btn-lg" type="button" data-phone-verify-generate>获取验证码</button>
                                    <button class="btn btn-round btn-lg" type="button" data-phone-verify-countdown style="display:none;margin:0;"></button>
                                    <button class="btn btn-round btn-lg" type="button" data-phone-verify-regenerate style="display:none;margin:0;">重新获取</button>
                                </div>
                            </div>
                        </div>
                    @endif

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

        /* 表单字段通用样式 */
        .field > label {
            width: 120px;
            color: #333;
            font-size: 14px;
            line-height: 40px;
            flex-shrink: 0;
            text-align: left;
            padding-right: 15px;
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
        .tags label.tag {
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
            width: auto;
            text-align: left;
            line-height: normal;
            flex-shrink: 1;
        }
        .tags label.tag:hover {
            border-color: #007bff;
            color: #007bff;
        }
        .tags label.tag.active {
            background: #e6f3ff;
            color: #007bff;
            border-color: #007bff;
        }
        .tags label.tag input[type="checkbox"] {
            display: none;
        }
        .tags label.tag.active::after {
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
        .tags label.tag.active span {
            padding-right: 24px;
        }

        /* 大神库选择样式 */
        .expert-database {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .expert-database-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        .expert-database-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        .expert-database-list label.database-item {
            display: flex;
            align-items: flex-start;
            padding: 10px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            text-align: left;
            line-height: normal;
            font-weight: normal;
        }
        .expert-database-list label.database-item:hover {
            border-color: #007bff;
        }
        .expert-database-list label.database-item input[type="checkbox"] {
            margin: 3px 10px 0 0;
            flex-shrink: 0;
        }
        .expert-database-list label.database-item span {
            flex: 1;
            min-width: 0;
            font-size: 14px;
            color: #333;
        }
        .certificate-upload {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .certificate-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .upload-area {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
        }
        .upload-area:hover {
            border-color: #007bff;
        }
        .certificate-input {
            display: none;
        }
        .upload-tip {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        /* Enterprise form styles */
        .enterprise-welcome {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .enterprise-welcome h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .enterprise-welcome p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .section-note {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .field-help {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        .required {
            color: #ff4d4f;
            margin-left: 4px;
        }
        select.form-lg {
            height: 40px;
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }
        textarea.form-lg {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }

        /* 基础表单样式 */
        .register-form {
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* 表单项容器 */
        .line {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }
        
        /* 表单字段样式 */
        .field {
            position: relative;
            width: 100%;
            display: flex;
            align-items: flex-start;
        }
        
        /* 标签样式 */
        .field label {
            width: 120px;
            color: #333;
            font-size: 14px;
            line-height: 40px;
            flex-shrink: 0;
            text-align: left;
            padding-right: 15px;
        }
        
        /* 必填星号 */
        .required {
            color: #ff4d4f;
            margin-right: 2px;
            font-family: SimSun;
            font-size: 14px;
        }
        
        /* 输入框容器 */
        .field-content {
            flex: 1;
            min-width: 0;
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
        
        /* 帮助文本 */
        .field-help {
            margin-top: 4px;
            color: #999;
            font-size: 12px;
        }
        
        /* 表单分组样式 */
        .form-group {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .form-group-title {
            font-size: 16px;
            font-weight: 500;
            color: #17233d;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8eaec;
        }
        
        .form-group-subtitle {
            font-size: 12px;
            color: #808695;
            margin: -15px 0 20px;
        }
        
        /* 下拉框样式 */
        select.form-lg {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8.825L1.175 4 2.238 2.938 6 6.7l3.763-3.762L10.825 4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            padding-right: 24px;
        }
        
        /* 文本域样式 */
        textarea.form-lg {
            min-height: 100px;
            resize: vertical;
        }
        
        /* 按钮样式优化 */
        .btn-block {
            margin-left: 120px;
            width: calc(100% - 120px);
        }
        
        /* 验证码区域样式 */
        .captcha-group {
            display: flex;
            gap: 10px;
        }
        
        .captcha-group input {
            flex: 1;
        }
        
        .captcha-group button {
            width: 120px;
            white-space: nowrap;
        }

        /* 注册说明文本 */
        .register-note {
            color: #999;
            font-size: 12px;
            margin-top: 30px;
            text-align: center;
        }
    </style>
@endsection
