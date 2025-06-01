<?php

namespace Module\Blog\Member\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Module\Blog\Member\Auth\MemberUser;
use Module\Blog\Member\Model\Member;
use Module\Member\Util\MemberMetaUtil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // 引入 Str Facade 用于生成文件名
use ModStart\Core\Input\Response; // Added ModStart Response

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

        return \ModStart\Core\Input\Response::generateSuccess(null, '/');
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
        $registerType = $request->input('registerType', 'personal');

        $rules = [];
        $messages = [];

        if ($registerType === 'personal') {
            // 个人注册验证规则
            $rules = [
                'phone' => 'required|string|regex:/^1[3-9]\d{9}$/|unique:member,phone',
                'verify_code' => 'required|string',
                'password' => 'required|string|min:6',
                'sports' => 'nullable|array',
            ];
            $messages = [
                'phone.required' => '请输入手机号',
                'phone.regex' => '请输入正确的手机号格式',
                'phone.unique' => '该手机号已被注册',
                'verify_code.required' => '请输入验证码',
                'password.required' => '请输入密码',
                'password.min' => '密码长度至少为6位',
            ];
        } elseif ($registerType === 'expert') {
            // 专家注册验证规则
            $rules = [
                'realname' => 'required|string',
                'expert_email' => 'required|string|email',
                'area' => 'required|string',
                'contact_info' => 'required|string',
                'sports' => 'required|array',
                'expert_libraries' => 'required|array',
                'certs.*' => 'required|file|mimes:jpg,png,pdf|max:10240', // 证书文件验证 (每个文件)
                'password' => 'required|string|min:6',
                'passwordRepeat' => 'required|string|same:password',
                'captcha' => 'required|string', // Assuming captcha is always required for expert
            ];
            $messages = [
                'realname.required' => '请输入姓名',
                'expert_email.required' => '请输入常用邮箱',
                'expert_email.email' => '请输入正确的邮箱格式',
                'area.required' => '请输入所在地区',
                'contact_info.required' => '请输入联系信息',
                'sports.required' => '请选择喜欢的运动',
                'sports.array' => '运动信息格式不正确',
                'expert_libraries.required' => '请选择要录入的大神库',
                'expert_libraries.array' => '大神库信息格式不正确',
                'certs.*.required' => '请上传证书文件',
                'certs.*.file' => '证书文件上传失败',
                'certs.*.mimes' => '证书文件只支持jpg,png,pdf格式',
                'certs.*.max' => '证书文件大小不能超过10MB',
                'password.required' => '请输入密码',
                'password.min' => '密码长度至少为6位',
                'passwordRepeat.required' => '请重复输入密码',
                'passwordRepeat.same' => '两次输入的密码不一致',
                'captcha.required' => '请输入图片验证码',
            ];

            // Add phone/email verification if enabled in config
            if (modstart_config('registerPhoneEnable')) {
                $rules['phone'] = 'required|string|regex:/^1[3-9]\d{9}$/|unique:member,phone';
                $rules['phoneVerify'] = 'required|string';
                $messages['phone.required'] = '请输入手机号';
                $messages['phone.regex'] = '请输入正确的手机号格式';
                $messages['phone.unique'] = '该手机号已被注册';
                $messages['phoneVerify.required'] = '请输入手机验证码';
            }
            if (modstart_config('registerEmailEnable')) {
                $rules['email'] = 'required|string|email|unique:member,email';
                $rules['emailVerify'] = 'required|string';
                $messages['email.required'] = '请输入邮箱';
                $messages['email.email'] = '请输入正确的邮箱格式';
                $messages['email.unique'] = '该邮箱已被注册';
                $messages['emailVerify.required'] = '请输入邮箱验证码';
            }
        } else {
            // 未知注册类型
             return back()->withErrors(['registerType' => '未知的注册类型'])->withInput();
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 验证短信/邮箱验证码 (这里需要根据实际验证码模块实现)
        // 为了演示，我们暂时跳过验证
        // if ($registerType === 'personal' && modstart_config('registerPhoneEnable')) { ... 验证手机验证码 ... }
        // if ($registerType === 'personal' && modstart_config('registerEmailEnable')) { ... 验证邮箱验证码 ... }
        // if ($registerType === 'expert' && modstart_config('registerPhoneEnable')) { ... 验证手机验证码 ... }
        // if ($registerType === 'expert' && modstart_config('registerEmailEnable')) { ... 验证邮箱验证码 ... }
        // if ($registerType === 'expert') { ... 验证图片验证码 ... }

        dd(111);
        // 创建用户
        $member = Member::create([
            'username' => $request->input('username', $request->input('phone', $request->input('expert_email')) ? substr($request->input('phone', $request->input('expert_email')), -4) : null),
            'phone' => $request->input('phone'),
            'email' => $request->input('email', $request->input('expert_email')), // Use expert_email if provided
            'password' => Hash::make($request->input('password')),
            'status' => 1, // 默认状态
            'realname' => $request->input('realname'), // 专家注册字段
            'area' => $request->input('area'), // 专家注册字段
            'contact_info' => $request->input('contact_info'), // 专家注册字段
            'expert_status' => ($registerType === 'expert') ? 1 : 0, // 设置专家状态为待审核
        ]);

        // 处理专家注册特有信息
        if ($registerType === 'expert') {
            // 保存喜欢的运动到 member_meta
            $sports = $request->input('sports');
            if (!empty($sports) && is_array($sports)) {
                MemberMetaUtil::set($member->id, 'favorite_sports', json_encode($sports));
            }

            // 保存选择的大神库到 member_meta
            $expertLibraries = $request->input('expert_libraries');
            if (!empty($expertLibraries) && is_array($expertLibraries)) {
                MemberMetaUtil::set($member->id, 'expert_libraries', json_encode($expertLibraries));
            }

            // 处理证书文件上传并保存信息到 member_meta
            $certFiles = $request->file('certs');
            $uploadedCertsInfo = [];
            if (!empty($certFiles)) {
                foreach ($certFiles as $certFile) {
                    if ($certFile->isValid()) {
                        $originalName = $certFile->getClientOriginalName();
                        $extension = $certFile->getClientOriginalExtension();
                        // 生成唯一的存储文件名，保留原扩展名
                        $fileName = 'cert_' . $member->id . '_' . Str::random(10) . '.' . $extension;
                        // 保存文件到 storage/app/public/cert 目录下
                        $path = $certFile->storeAs('public/cert', $fileName);

                        // 记录证书信息 (存储路径和原始文件名)
                        $uploadedCertsInfo[] = [
                            'path' => Storage::url($path), // 获取可公开访问的URL
                            'original_name' => $originalName,
                            'extension' => $extension,
                            'size' => $certFile->getSize(),
                        ];
                    }
                }
            }
            if (!empty($uploadedCertsInfo)) {
                 MemberMetaUtil::set($member->id, 'certs', json_encode($uploadedCertsInfo));
            }
        }

        // 登录用户
        MemberUser::login($member);

        // 注册成功事件
        // EventUtil::dispatch(new MemberUserRegisteredEvent($member->id));

        return \ModStart\Core\Input\Response::generateSuccess(null, '/');
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
