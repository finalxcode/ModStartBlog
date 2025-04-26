@extends('blog.member::layout.auth')

@section('title', '登录')

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
            <form action="{{ url('blog/member/login') }}" method="post">
                @csrf
                <div class="ub-form">
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg w-100" name="phone" placeholder="请输入手机号" value="{{ old('phone') }}">
                            @if($errors->has('phone'))
                                <div class="help-block text-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <input type="password" class="form-lg w-100" name="password" placeholder="请输入密码">
                            @if($errors->has('password'))
                                <div class="help-block text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">登录</button>
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
                                    <a href="{{ url('blog/member/register') }}" class="btn btn-lg btn-block">
                                        没有账号，立即注册
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
</style>
@endsection
