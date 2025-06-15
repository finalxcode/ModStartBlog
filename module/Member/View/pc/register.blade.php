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
            var needCaptcha = {!! \Module\Member\Util\SecurityUtil::registerCaptchaProvider() ? false : true !!};
            

            
            // 显示字段错误信息
            function showFieldError(fieldName, errorMessage) {
                var $field = $('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');
                if ($field.length > 0) {
                    $field.addClass('error');
                    var $errorDiv = $('<div class="field-error">' + errorMessage + '</div>');
                    $field.closest('.field, .field-content').append($errorDiv);
                }
            }
            
            // 添加调试日志
            console.log('注册页面JavaScript已加载');
            console.log('jQuery版本:', $.fn.jquery);
            console.log('window.__msRoot:', window.__msRoot);
            console.log('ModStart相关对象:', {
                ModStart: typeof window.ModStart,
                api: typeof window.api,
                Dialog: typeof window.Dialog
            });
            
            // 检查页面加载的脚本
            console.log('页面加载的脚本文件:');
            $('script[src]').each(function(index) {
                console.log('脚本 ' + index + ':', $(this).attr('src'));
            });
            
            // 监听表单提交事件
            $('form[data-ajax-form]').on('submit', function(e) {
                console.log('表单提交事件触发:', e);
                console.log('表单元素:', this);
                console.log('表单data-ajax-form属性:', $(this).attr('data-ajax-form'));
                
                // 显示表单数据（根据是否有文件上传使用不同方式）
                var $form = $(this);
                if ($form.find('input[type="file"]').length > 0) {
                    console.log('表单包含文件上传，将使用FormData');
                    var formDataEntries = [];
                    $form.find('input, select, textarea').each(function() {
                        if (this.type !== 'file' && this.name) {
                            if (this.type === 'checkbox' || this.type === 'radio') {
                                if (this.checked) {
                                    formDataEntries.push(this.name + '=' + encodeURIComponent(this.value));
                                }
                            } else {
                                formDataEntries.push(this.name + '=' + encodeURIComponent(this.value));
                            }
                        }
                    });
                    console.log('表单数据（不含文件）:', formDataEntries.join('&'));
                } else {
                    console.log('表单数据:', $(this).serialize());
                }
                
                console.log('事件是否被阻止:', e.isDefaultPrevented());
                
                // 阻止默认的表单提交和任何其他处理器
                e.preventDefault();
                e.stopImmediatePropagation();
                console.log('已阻止默认表单提交');
                
                // 强制移除所有可能的loading状态
                var $submitBtn = $(this).find('button[type="submit"]');
                $submitBtn.prop('disabled', false).text('提交注册');
                
                // 查找并移除所有loading相关的元素和类
                $('.loading, .ub-loading, .layui-loading, [data-loading]').remove();
                $('body, html, .ub-form, form').removeClass('loading ub-loading layui-loading');
                $submitBtn.removeClass('loading ub-loading layui-loading disabled');
                
                console.log('强制清除loading状态');
                
                // 设置定时器持续清除loading状态
                var clearLoadingInterval = setInterval(function() {
                    $('.loading, .ub-loading, .layui-loading, [data-loading]').remove();
                    $('body, html, .ub-form, form').removeClass('loading ub-loading layui-loading');
                    
                    // 强制恢复所有提交按钮的状态
                    $('button[type="submit"]').each(function() {
                        var $btn = $(this);
                        if ($btn.prop('disabled') || $btn.text().indexOf('提交中') !== -1 || $btn.text().indexOf('loading') !== -1) {
                            $btn.prop('disabled', false).text('提交注册');
                            $btn.removeClass('loading ub-loading layui-loading disabled');
                            console.log('强制恢复按钮状态:', $btn[0]);
                        }
                    });
                    
                    // 专门清除Layui的loading遮罩层
                    var layuiLoadingElements = $('.layui-layer-loading, .layui-layer-loading2, .layui-layer-loading-2, [id^="layui-layer"]');
                    if (layuiLoadingElements.length > 0) {
                        console.log('发现Layui loading元素:', layuiLoadingElements.toArray());
                        layuiLoadingElements.each(function() {
                            var $el = $(this);
                            console.log('移除Layui loading元素:', {
                                element: this,
                                id: $el.attr('id'),
                                classes: $el.attr('class')
                            });
                            $el.remove();
                        });
                    }
                    
                    // 清除其他可能的loading元素（但排除页面基本元素）
                    var otherLoadingElements = $('.loading, .spinner, .ub-loading, [data-loading]').not('html, head, body, script, style');
                    if (otherLoadingElements.length > 0) {
                        console.log('发现其他loading元素:', otherLoadingElements.toArray());
                        otherLoadingElements.remove();
                    }
                    
                    console.log('定时清除loading状态');
                }, 100);
                
                // 5秒后停止定时器
                setTimeout(function() {
                    clearInterval(clearLoadingInterval);
                    console.log('停止定时清除loading');
                }, 5000);
                
                // 尝试手动发送AJAX请求来测试后端
                var $form = $(this);
                console.log('准备手动发送AJAX请求...');
                
                // 设置loading状态
                $submitBtn.prop('disabled', true).text('提交中...');
                
                // 检查表单是否包含文件上传
                var hasFileUpload = $form.find('input[type="file"]').length > 0;
                var formData;
                var contentType = false;
                var processData = false;
                
                if (hasFileUpload) {
                    // 使用FormData处理文件上传
                    formData = new FormData($form[0]);
                    console.log('检测到文件上传，使用FormData');
                    
                    // 检查文件是否被选择
                    $form.find('input[type="file"]').each(function() {
                        var files = this.files;
                        console.log('文件字段 ' + this.name + ':', files.length + ' 个文件');
                        for (var i = 0; i < files.length; i++) {
                            console.log('文件 ' + i + ':', files[i].name, files[i].size + ' bytes');
                        }
                    });
                } else {
                    // 普通表单数据
                    formData = $form.serialize();
                    contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
                    processData = true;
                    console.log('普通表单，使用serialize');
                }
                
                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: formData,
                    contentType: contentType,
                    processData: processData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        console.log('手动AJAX请求开始');
                    },
                    success: function(response) {
                        console.log('手动AJAX请求成功:', response);
                        
                        // 恢复按钮状态并强制清除loading
                        $submitBtn.prop('disabled', false).text('提交注册');
                        
                        // 强制清除所有loading状态
                        $('.loading, .ub-loading, .layui-loading, [data-loading]').remove();
                        $('body, html, .ub-form, form').removeClass('loading ub-loading layui-loading');
                        $submitBtn.removeClass('loading ub-loading layui-loading disabled');
                        
                        console.log('AJAX成功后强制清除loading状态');
                        
                        // 清除之前的错误信息
                        $('.field-error').remove();
                        $('.form-lg').removeClass('error');
                        
                        // 如果有字段级别的错误，显示它们
                        if (response.code !== 0 && response.errors && typeof response.errors === 'object') {
                            console.log('显示字段错误:', response.errors);
                            for (var fieldName in response.errors) {
                                var errors = response.errors[fieldName];
                                if (Array.isArray(errors) && errors.length > 0) {
                                    showFieldError(fieldName, errors[0]);
                                }
                            }
                        } else if (response.code === 0) {
                            console.log('注册成功!');
                            $submitBtn.text('注册成功!');
                            alert('注册成功!');
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        } else if (response.msg) {
                            alert(response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('手动AJAX请求失败:', {xhr, status, error});
                        console.log('响应内容:', xhr.responseText);
                        
                        // 恢复按钮状态并强制清除loading
                        $submitBtn.prop('disabled', false).text('提交注册');
                        
                        // 强制清除所有loading状态
                        $('.loading, .ub-loading, .layui-loading, [data-loading]').remove();
                        $('body, html, .ub-form, form').removeClass('loading ub-loading layui-loading');
                        $submitBtn.removeClass('loading ub-loading layui-loading disabled');
                        
                        console.log('AJAX错误后强制清除loading状态');
                        alert('提交失败，请重试');
                    }
                });
            });
            

            
            // 监听按钮点击事件
            $('button[type="submit"]').on('click', function(e) {
                console.log('提交按钮被点击:', e);
                console.log('按钮元素:', this);
                console.log('所属表单:', $(this).closest('form')[0]);
            });
            
            // 检查表单状态
            setTimeout(function() {
                console.log('页面加载完成后的表单状态:');
                $('form[data-ajax-form]').each(function(index) {
                    console.log('表单 ' + index + ':', {
                        element: this,
                        action: $(this).attr('action'),
                        method: $(this).attr('method'),
                        dataAjaxForm: $(this).attr('data-ajax-form'),
                        visible: $(this).is(':visible')
                    });
                });
            }, 1000);
            
            // 当用户开始输入时清除错误信息
            $(document).on('input change', '.form-lg.error', function() {
                $(this).removeClass('error');
                $(this).closest('.field, .field-content').find('.field-error').remove();
            });
            
            // 注册类型切换
            $('.register-type-item').click(function(){
                $('.register-type-item').removeClass('active');
                $(this).addClass('active');
                $('.register-form').hide();
                $('.register-form[data-type="'+$(this).data('type')+'"]').show();
                // 切换时清除错误信息
                $('.field-error').remove();
                $('.form-lg').removeClass('error');
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

            // 触发证书上传文件选择
            $('.expert-register-form .upload-area').on('click', function(event) {
                // 检查事件来源，如果点击的是删除按钮或其内部，则不触发文件输入
                if (!$(event.target).closest('.remove-file').length) {
                    $(this).closest('.certificate-upload').find('.certificate-input')[0].click();
                }
            });

            // 处理证书文件选择后的显示和删除逻辑
            $('.expert-register-form .certificate-input').on('change', function() {
                var files = this.files;
                var fileListContainer = $('.expert-register-form .upload-area');
                fileListContainer.find('.certificate-file-item').remove(); 

                if (files.length > 0) {
                    fileListContainer.find('.upload-tip').hide();
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var fileName = file.name;
                        var fileSize = (file.size / 1024 / 1024).toFixed(2);

                        var fileElement = $('\n                            <div class="certificate-file-item">\n                                <span class="file-name">' + fileName + ' (' + fileSize + ' MB)</span>\n                                <span class="remove-file"><i class="iconfont icon-close"></i></span>\n                            </div>\n                        ');

                        // 将文件数据存储在元素上，以便后续处理（如果需要的话）
                        // fileElement.data('file', file);

                        fileListContainer.append(fileElement);
                    }
                } else {
                    fileListContainer.find('.upload-tip').show();
                }
            });

            // 监听删除按钮点击事件
            $('.expert-register-form').on('click', '.remove-file', function(event) {
                event.stopPropagation();
                event.preventDefault();
                $(this).closest('.certificate-file-item').remove();
                if ($('.expert-register-form .certificate-file-item').length === 0) {
                    $('.expert-register-form .upload-area').find('.upload-tip').show();
                }
                // 注意：这里的移除只是移除了显示元素，并没有从 file input 中移除文件
                // 如果需要真正的文件管理，需要更复杂的逻辑，例如使用 DataTransfer 或维护一个文件数组
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
                    <i class="iconfont icon-corp"></i>
                    <div class="title">企业注册</div>
                    <div class="desc">企业用户注册</div>
                </div>
            </div>

            <div class="ub-form flat">
                <!-- 个人注册表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form="true" class="register-form" data-type="personal">
                    <input type="hidden" name="registerType" value="personal">
                    
                    <div class="line">
                        <div class="field">
                            <div class="sports-tags">
                                <div class="sports-tags-title">选择自己喜欢的运动</div>
                                <div class="tags">
                                    <label class="tag"><input type="checkbox" name="sports[]" value="road_running" checked><span>路跑</span></label>
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
                            <input type="text" class="form-lg" name="username" placeholder="用户名" value="test_user_personal" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" value="password123" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="passwordRepeat" placeholder="重复密码" value="password123" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-7">
                                    <input type="text" class="form-lg" name="phone" placeholder="输入手机号" value="13800138001" />
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

                    <!-- @include('module::Member.View.pc.inc.registerCaptcha') -->
                    <div class="line" id="captcha-line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-10">
                                    <input type="text" class="form-lg" name="captcha" autocomplete="off"
                                        onfocus="$(this).attr('data-form-process','processing')"
                                        placeholder="图片验证码" />
                                </div>
                                <div class="col-2">
                                    <img class="captcha captcha-lg" data-captcha title="刷新验证"
                                        onclick="this.src=window.__msRoot+'register/captcha?'+Math.random()"
                                        src="{{$__msRoot}}register/captcha?{{time()}}" />
                                </div>
                            </div>
                            <div class="help">
                                <span class="ub-text-muted" data-captcha-status="tip"><i class="iconfont icon-warning"></i> 输入图片验证码验证</span>
                                <span class="ub-text-muted" data-captcha-status="loading" style="display:none;"><i class="iconfont icon-refresh"></i> 正在验证</span>
                                <span class="ub-text-success" data-captcha-status="success" style="display:none;"><i class="iconfont icon-checked"></i> 验证通过</span>
                                <span class="ub-text-danger" data-captcha-status="error" style="display:none;"><i class="iconfont icon-close-o"></i> 验证失败</span>
                            </div>
                        </div>
                    </div>

                    @if(modstart_config('registerEmailEnable'))
                        <div class="line">
                            <div class="field">
                                <div class="row no-gutters">
                                    <div class="col-7">
                                        <input type="text" class="form-lg" name="email" placeholder="输入邮箱" value="test@example.com" />
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
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form="true" class="register-form expert-register-form" data-type="expert" style="display:none;" enctype="multipart/form-data">
                <!-- <form action="{{$__msRoot}}blog/member/register" method="post" data-ajax-form class="register-form expert-register-form" data-type="expert" style="display:none;" enctype="multipart/form-data"> -->
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
                                    <label class="tag"><input type="checkbox" name="sports[]" value="road_running" checked><span>路跑</span></label>
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
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="marathon_sub3" checked><span>中国马拉松破三跑者库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="ultra_100k"><span>中国百公里越野赛跑者库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="cycling_level3"><span>达到国家三级运动员水平骑者库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="roller_level3"><span>达到国家三级运动员标准轮滑大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="downhill_level3"><span>达到国家三级运动员标准速降大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="mountaineering_level3"><span>达到国家三级运动员标准登山大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="rock_climbing_level3"><span>达到国家三级运动员标准攀岩大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="swimming_level3"><span>达到国家三级运动员标准游泳大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="kayaking_level3"><span>达到国家三级运动员标准皮划艇大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="diving_level3"><span>达到国家三级运动员标准潜水大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="ice_climbing_level3"><span>达到国家三级运动员标准攀冰大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="skiing_level3"><span>达到国家三级运动员标准滑雪大神库</span></label>
                                    <label class="database-item"><input type="checkbox" name="expert_libraries[]" value="ice_skating_level3"><span>达到国家三级运动员标准滑冰大神库</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <div class="certificate-upload">
                                <div class="certificate-title">上传您的证书</div>
                                <div class="upload-area">
                                    <input type="file" name="certs[]" multiple accept=".jpg,.png,.pdf" class="certificate-input" />
                                    <div class="upload-tip">支持jpg、png、pdf格式，大小不超过10MB</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="real_name" placeholder="姓名（必填）" required value="测试大神" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="email" class="form-lg" name="email" placeholder="常用邮箱（必填）" required style="width: 100%;" value="expert@example.com" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="area" placeholder="所在地区（必填）" required value="测试地区" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="contact_name" placeholder="联系信息（姓名须与证书一致）" required value="测试联系人" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="username" placeholder="用户名（必填）" required value="test_expert_user" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password" placeholder="输入密码" required value="password123" />
                        </div>
                    </div>

                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg" name="password_repeat" placeholder="重复密码" required value="password123" />
                        </div>
                    </div>

                    <!-- @include('module::Member.View.pc.inc.registerCaptcha') -->
                    <div class="line" id="captcha-line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-10">
                                    <input type="text" class="form-lg" name="captcha" autocomplete="off"
                                        onfocus="$(this).attr('data-form-process','processing')"
                                        placeholder="图片验证码" />
                                </div>
                                <div class="col-2">
                                    <img class="captcha captcha-lg" data-captcha title="刷新验证"
                                        onclick="this.src=window.__msRoot+'register/captcha?'+Math.random()"
                                        src="{{$__msRoot}}register/captcha?{{time()}}" />
                                </div>
                            </div>
                            <div class="help">
                                <span class="ub-text-muted" data-captcha-status="tip"><i class="iconfont icon-warning"></i> 输入图片验证码验证</span>
                                <span class="ub-text-muted" data-captcha-status="loading" style="display:none;"><i class="iconfont icon-refresh"></i> 正在验证</span>
                                <span class="ub-text-success" data-captcha-status="success" style="display:none;"><i class="iconfont icon-checked"></i> 验证通过</span>
                                <span class="ub-text-danger" data-captcha-status="error" style="display:none;"><i class="iconfont icon-close-o"></i> 验证失败</span>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-7">
                                    <input type="text" class="form-lg" name="phone" placeholder="输入手机号" value="13800138002" />
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

                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">提交注册</button>
                        </div>
                    </div>
                </form>

                <!-- 企业注册表单 -->
                <form action="{{\ModStart\Core\Input\Request::currentPageUrl()}}" method="post" data-ajax-form="true" class="register-form enterprise-register-form" data-type="enterprise" style="display:none;">
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
                                        <option value="sports_store" selected>运动器材及用品店</option>
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
                                    <input type="text" class="form-lg" name="username" required value="test_enterprise_user" />
                                    <div class="field-help">不支持汉字，不能以数字开头；建议使用公司名的字母缩写</div>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>登录密码</label>
                                <div class="field-content">
                                    <input type="password" class="form-lg" name="password" required value="password123" />
                                    <div class="field-help">密码由6-20个英文字母（区分大小写）或数字组成</div>
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>确认密码</label>
                                <div class="field-content">
                                    <input type="password" class="form-lg" name="passwordRepeat" required value="password123" />
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
                                    <input type="text" class="form-lg" name="companyName" required value="测试企业名称" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>所在地区</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="location" required value="测试企业地区" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>企业规模</label>
                                <div class="field-content">
                                    <select class="form-lg" name="companySize" required>
                                        <option value="">请选择企业规模</option>
                                        <option value="1-10" selected>1-10人</option>
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
                                        <option value="0-100" selected>100万以下</option>
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
                                    <textarea class="form-lg" name="companyDescription" rows="4">测试企业简介</textarea>
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
                                    <input type="text" class="form-lg" name="contactName" required value="测试联系人企业" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>职位</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="contactPosition" required value="测试职位" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>电话</label>
                                <div class="field-content">
                                    <input type="tel" class="form-lg" name="telephone" required value="010-12345678" />
                                </div>
                            </div>
                        </div>

                        

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>邮编</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="zipCode" required value="100000" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>通讯地址</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="address" required value="测试通讯地址" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>常用邮箱</label>
                                <div class="field-content">
                                    <input type="email" class="form-lg" name="email" required value="enterprise@example.com" />
                                </div>
                            </div>
                        </div>

                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>公司网址</label>
                                <div class="field-content">
                                    <input type="url" class="form-lg" name="website" required value="https://www.example.com" />
                                </div>
                            </div>
                        </div>


                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>手机</label>
                                <div class="field-content">
                                    <div class="row no-gutters">
                                        <div class="col-7">
                                            <input type="text" class="form-lg" name="phone" placeholder="输入手机号" value="13800138001" />
                                        </div>
                                        <div class="col-5">
                                            <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-generate>获取验证码</button>
                                            <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-countdown style="display:none;margin:0;"></button>
                                            <button class="btn btn-round btn-lg btn-block" type="button" data-phone-verify-regenerate style="display:none;margin:0;">重新获取</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>手机验证码</label>
                                <div class="field-content">
                                    <input type="text" class="form-lg" name="phoneVerify" placeholder="手机验证码" />
                                </div>
                            </div>
                        </div>


                        <div class="line">
                            <div class="field">
                                <label><span class="required">*</span>图片验证码</label>
                                <div class="field-content" style="display: flex; align-items: center;">
                                    <input type="text" class="form-lg" name="captcha" autocomplete="off"
                                        onfocus="$(this).attr('data-form-process','processing')"
                                        placeholder="图片验证码" style="flex-grow: 1; margin-right: 10px;" />
                                    <img class="captcha captcha-lg" data-captcha title="刷新验证"
                                        onclick="this.src='{{$__msRoot}}register/captcha?'+Math.random()"
                                        src="{{$__msRoot}}register/captcha?{{time()}}" style="height: 40px; width: auto;" />
                                </div>
                                <div class="help">
                                    <!-- <span class="ub-text-muted" data-captcha-status="tip"><i class="iconfont icon-warning"></i> 输入图片验证码验证</span> -->
                                    <span class="ub-text-muted" data-captcha-status="loading" style="display:none;"><i class="iconfont icon-refresh"></i> 正在验证</span>
                                    <span class="ub-text-success" data-captcha-status="success" style="display:none;"><i class="iconfont icon-checked"></i> 验证通过</span>
                                    <span class="ub-text-danger" data-captcha-status="error" style="display:none;"><i class="iconfont icon-close-o"></i> 验证失败</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- @include('module::Member.View.pc.inc.registerCaptcha')
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
                    @endif -->

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

        /* 错误信息样式 */
        .field-error {
            color: #ff4d4f;
            font-size: 12px;
            margin-top: 4px;
            line-height: 1.4;
        }
        
        .form-lg.error {
            border-color: #ff4d4f !important;
            box-shadow: 0 0 0 2px rgba(255, 77, 79, 0.2) !important;
        }
        
        .form-lg.error:focus {
            border-color: #ff4d4f !important;
            box-shadow: 0 0 0 2px rgba(255, 77, 79, 0.2) !important;
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
            display: flex;
            flex-direction: column;
            align-items: stretch;
            padding: 15px;
            border: 2px dashed #ddd;
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
            margin-top: 0;
            margin-bottom: 15px;
            text-align: center;
            width: 100%;
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
        }

        /* 专家注册表单特定样式 */
        .expert-register-form .field {
            position: relative;
            width: 100%;
        }

        /* 企业注册表单特定样式 */
        .enterprise-register-form .field {
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
            width: 200px;
            margin: 0 auto;
            display: block;
        }
        
        /* 按钮容器居中 */
        .register-form .line:has(button[type="submit"]) .field {
            text-align: center;
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

        /* 证书文件列表样式 */
        .certificate-file-list {
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background-color: #fff;
        }

        .certificate-file-item {
            display: flex;
            align-items: center;
            padding: 5px 8px;
            margin-bottom: 5px;
            border: 1px solid #eee;
            border-radius: 4px;
            background-color: #f9f9f9;
            width: 100%;
            box-sizing: border-box;
        }

        .certificate-file-item .file-name {
            flex-grow: 1;
            font-size: 14px;
            color: #333;
            word-break: break-all;
            margin-right: 10px;
        }

        .certificate-file-item .remove-file {
            color: #f00;
            cursor: pointer;
            font-size: 16px;
            flex-shrink: 0;
        }

        .certificate-file-item .remove-file:hover {
            color: #c00;
        }

        /* 证书上传区域样式调整 */
        .certificate-upload .upload-area {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            padding: 15px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        /* 证书文件列表项样式 */
        .certificate-file-item {
            display: flex;
            align-items: center;
            padding: 5px 8px;
            margin-bottom: 5px;
            border: 1px solid #eee;
            border-radius: 4px;
            background-color: #f9f9f9;
            width: 100%;
            box-sizing: border-box;
        }

        .certificate-file-item:last-child {
            margin-bottom: 0;
        }

        .certificate-file-item .file-name {
            flex-grow: 1;
            font-size: 14px;
            color: #333;
            word-break: break-all;
            margin-right: 10px;
        }

        .certificate-file-item .remove-file {
            color: #f00;
            cursor: pointer;
            font-size: 16px;
            flex-shrink: 0;
        }

        .certificate-file-item .remove-file:hover {
            color: #c00;
        }

        /* 隐藏原有的文件输入框 */
        .certificate-input {
            display: none;
        }

        /* 上传提示样式 */
        .upload-tip {
            font-size: 12px;
            color: #666;
            margin-top: 0;
            margin-bottom: 15px;
            text-align: center;
            width: 100%;
        }

        /* 当.upload-area中包含证书文件项时，调整.upload-tip的底部外边距 */
        .upload-area:has(.certificate-file-item) .upload-tip {
            margin-bottom: 10px;
        }
    </style>
@endsection
