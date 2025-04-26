@extends('blog.member::layout.auth')

@section('title', '注册')

@section('content')
<div class="ub-container">
    <div class="ub-panel">
        <div class="head">
            <div class="title text-center">
                <div class="logo-container">
                    <img src="{{ asset('asset/image/logo.png') }}" alt="运动圈" class="logo">
                </div>
                <h3>运动圈</h3>
            </div>
        </div>
        <div class="body">
            <form action="{{ url('blog/member/register') }}" method="post" id="registerForm">
                @csrf
                <div class="ub-form">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg w-100" name="phone" placeholder="请输入中国大陆地区手机号" value="{{ old('phone') }}">
                            @if($errors->has('phone'))
                                <div class="help-block text-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <button type="button" class="btn btn-lg w-100" id="btnSmartVerify">点击按钮开始智能验证</button>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field input-group">
                            <input type="text" class="form-lg" name="verify_code" placeholder="输入短信验证码" style="flex: 1;">
                            <button type="button" class="btn btn-lg" id="btnSendCode">获取短信验证码</button>
                        </div>
                        @if($errors->has('verify_code'))
                            <div class="help-block text-danger">{{ $errors->first('verify_code') }}</div>
                        @endif
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg w-100" name="password" placeholder="设置密码">
                            @if($errors->has('password'))
                                <div class="help-block text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <label class="ub-checkbox">
                                <input type="checkbox" name="agree" value="1" checked>
                                <span class="text">我已经阅读并同意 <a href="#" target="_blank">运动圈 用户协议及隐私条款</a></span>
                            </label>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-lg" data-type="personal">个人注册</button>
                                <button type="button" class="btn btn-lg" data-type="team">大神入驻</button>
                                <button type="button" class="btn btn-lg" data-type="enterprise">企业注册</button>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="alert alert-warning">
                                非企业会员无权限分享品牌故事及发布运动器材与用品店
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-lg btn-block" id="wechatLogin">
                                        <i class="iconfont icon-wechat"></i> 微信登录
                                    </button>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('blog/member/login') }}" class="btn btn-lg btn-block">
                                        已有账号，立即登录
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        let countdown = 0;
        const countdownInterval = null;

        // 发送验证码
        $('#btnSendCode').on('click', function(){
            if(countdown > 0) return;

            const phone = $('input[name="phone"]').val();
            if(!phone) {
                alert('请输入手机号');
                return;
            }

            if(!/^1[3-9]\d{9}$/.test(phone)) {
                alert('请输入正确的手机号格式');
                return;
            }

            $.ajax({
                url: "{{ url('blog/member/send-verify-code') }}",
                type: 'POST',
                data: {
                    phone: phone,
                    check_exists: true,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if(res.success) {
                        alert(res.message);
                        countdown = 60;
                        $('#btnSendCode').prop('disabled', true).text(countdown + '秒后重新获取');

                        countdownInterval = setInterval(function(){
                            countdown--;
                            $('#btnSendCode').text(countdown + '秒后重新获取');
                            if(countdown <= 0) {
                                clearInterval(countdownInterval);
                                $('#btnSendCode').prop('disabled', false).text('获取短信验证码');
                            }
                        }, 1000);
                    } else {
                        alert(res.message);
                    }
                }
            });
        });

        // 智能验证
        $('#btnSmartVerify').on('click', function(){
            alert('智能验证通过');
        });

        // 注册类型选择
        $('.btn-group button').on('click', function(){
            const type = $(this).data('type');
            $('.btn-group button').removeClass('btn-primary');
            $(this).addClass('btn-primary');
            $('input[name="register_type"]').val(type);

            // 提交表单
            $('#registerForm').submit();
        });

        // 微信登录
        $('#wechatLogin').on('click', function(){
            alert('微信登录功能开发中');
        });
    });
</script>
<style>
    .logo-container {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo {
        width: 80px;
        height: 80px;
    }
    .btn-group {
        display: flex;
        width: 100%;
    }
    .btn-group .btn {
        flex: 1;
        margin: 0 5px;
    }
    .input-group {
        display: flex;
    }
    .input-group .btn {
        margin-left: 10px;
    }
</style>
@endsection
