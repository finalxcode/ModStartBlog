<?php

namespace Module\Blog\Member\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Module\Blog\Member\Auth\MemberUser;
use Module\Blog\Member\Model\Member;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (MemberUser::isLogin()) {
            return redirect('/');
        }
        return view('blog.member::auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = Member::where('phone', $request->phone)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            return back()->withErrors([
                'phone' => '手机号或密码错误',
            ])->withInput();
        }

        MemberUser::login($member);

        return redirect()->intended('/');
    }

    public function showRegisterForm()
    {
        if (MemberUser::isLogin()) {
            return redirect('/');
        }
        return view('blog.member::auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^1[3-9]\d{9}$/|unique:member,phone',
            'verify_code' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'phone.required' => '请输入手机号',
            'phone.regex' => '请输入正确的手机号格式',
            'phone.unique' => '该手机号已被注册',
            'verify_code.required' => '请输入验证码',
            'password.required' => '请输入密码',
            'password.min' => '密码长度至少为6位',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 验证短信验证码
        // 这里应该添加验证短信验证码的逻辑
        // 为了演示，我们暂时跳过验证

        $member = Member::create([
            'phone' => $request->phone,
            'username' => '用户'.substr($request->phone, -4),
            'password' => $request->password,
            'status' => 1,
        ]);

        MemberUser::login($member);

        return redirect('/');
    }

    public function logout()
    {
        MemberUser::logout();
        return redirect('/');
    }

    public function sendVerifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^1[3-9]\d{9}$/',
        ], [
            'phone.required' => '请输入手机号',
            'phone.regex' => '请输入正确的手机号格式',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        // 检查手机号是否已注册
        if ($request->has('check_exists') && $request->check_exists) {
            $exists = Member::where('phone', $request->phone)->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => '该手机号已被注册'
                ]);
            }
        }

        // 这里应该添加发送短信验证码的逻辑
        // 为了演示，我们返回成功

        return response()->json([
            'success' => true,
            'message' => '验证码已发送'
        ]);
    }
}
