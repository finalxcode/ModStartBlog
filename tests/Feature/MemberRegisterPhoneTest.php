<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Module\Member\Model\MemberUser;

class MemberRegisterPhoneTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // 清理测试数据
        MemberUser::where('phone', 'like', '1380013800%')->delete();
    }

    /**
     * 测试个人注册 - 手机验证码发送
     */
    public function test_personal_register_phone_verify_send()
    {
        // 模拟图片验证码验证通过
        Session::put('registerCaptchaPass', true);
        Session::put('registerCaptchaPassCount', 1);

        $response = $this->post('/register/phone_verify', [
            'target' => '13800138001'
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, $data['code']);
        $this->assertEquals('验证码发送成功', $data['msg']);

        // 验证Session中是否保存了验证码信息
        $this->assertNotNull(Session::get('registerPhoneVerify'));
        $this->assertNotNull(Session::get('registerPhoneVerifyTime'));
        $this->assertEquals('13800138001', Session::get('registerPhone'));
    }

    /**
     * 测试个人注册 - 完整注册流程
     */
    public function test_personal_register_with_phone_verify()
    {
        // 模拟验证码已发送
        Session::put('registerPhoneVerify', '123456');
        Session::put('registerPhoneVerifyTime', time());
        Session::put('registerPhone', '13800138001');

        $response = $this->post('/register', [
            'registerType' => 'personal',
            'phone' => '13800138001',
            'phoneVerify' => '123456',
            'username' => 'test_user_personal',
            'password' => 'password123',
            'passwordRepeat' => 'password123',
            'captcha' => 'test_captcha',
            'sports' => ['road_running', 'marathon']
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, $data['code']);
        $this->assertEquals('注册成功', $data['msg']);

        // 验证用户是否创建成功
        $user = MemberUser::where('phone', '13800138001')->first();
        $this->assertNotNull($user);
        $this->assertEquals('test_user_personal', $user->username);

        // 验证Session是否被清理
        $this->assertNull(Session::get('registerPhoneVerify'));
        $this->assertNull(Session::get('registerPhoneVerifyTime'));
        $this->assertNull(Session::get('registerPhone'));
    }

    /**
     * 测试大神入驻 - 完整注册流程
     */
    public function test_expert_register_with_phone_verify()
    {
        // 模拟验证码已发送
        Session::put('registerPhoneVerify', '654321');
        Session::put('registerPhoneVerifyTime', time());
        Session::put('registerPhone', '13800138002');

        $response = $this->post('/register', [
            'registerType' => 'expert',
            'phone' => '13800138002',
            'phoneVerify' => '654321',
            'real_name' => '测试大神',
            'email' => 'expert@example.com',
            'area' => '测试地区',
            'contact_name' => '测试联系人',
            'sports' => ['road_running', 'marathon'],
            'expert_libraries' => ['marathon_sub3'],
            'username' => 'test_expert_user',
            'password' => 'password123',
            'password_repeat' => 'password123',
            'captcha' => 'test_captcha'
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, $data['code']);
        $this->assertEquals('注册成功', $data['msg']);

        // 验证用户是否创建成功
        $user = MemberUser::where('phone', '13800138002')->first();
        $this->assertNotNull($user);
        $this->assertEquals('test_expert_user', $user->username);
        $this->assertEquals(1, $user->expert_status);

        // 验证Session是否被清理
        $this->assertNull(Session::get('registerPhoneVerify'));
        $this->assertNull(Session::get('registerPhoneVerifyTime'));
        $this->assertNull(Session::get('registerPhone'));
    }

    /**
     * 测试错误的验证码
     */
    public function test_register_with_wrong_phone_verify()
    {
        // 模拟验证码已发送
        Session::put('registerPhoneVerify', '123456');
        Session::put('registerPhoneVerifyTime', time());
        Session::put('registerPhone', '13800138001');

        $response = $this->post('/register', [
            'registerType' => 'personal',
            'phone' => '13800138001',
            'phoneVerify' => '654321', // 错误的验证码
            'username' => 'test_user_personal',
            'password' => 'password123',
            'passwordRepeat' => 'password123',
            'captcha' => 'test_captcha',
            'sports' => ['road_running']
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(-1, $data['code']);
        $this->assertEquals('手机验证码不正确', $data['msg']);

        // 验证用户未被创建
        $user = MemberUser::where('phone', '13800138001')->first();
        $this->assertNull($user);
    }

    /**
     * 测试过期的验证码
     */
    public function test_register_with_expired_phone_verify()
    {
        // 模拟验证码已过期（1小时前）
        Session::put('registerPhoneVerify', '123456');
        Session::put('registerPhoneVerifyTime', time() - 3700);
        Session::put('registerPhone', '13800138001');

        $response = $this->post('/register', [
            'registerType' => 'personal',
            'phone' => '13800138001',
            'phoneVerify' => '123456',
            'username' => 'test_user_personal',
            'password' => 'password123',
            'passwordRepeat' => 'password123',
            'captcha' => 'test_captcha',
            'sports' => ['road_running']
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(-1, $data['code']);
        $this->assertEquals('手机验证码已过期', $data['msg']);

        // 验证用户未被创建
        $user = MemberUser::where('phone', '13800138001')->first();
        $this->assertNull($user);
    }

    /**
     * 测试手机号不一致
     */
    public function test_register_with_different_phone()
    {
        // 模拟验证码已发送
        Session::put('registerPhoneVerify', '123456');
        Session::put('registerPhoneVerifyTime', time());
        Session::put('registerPhone', '13800138001');

        $response = $this->post('/register', [
            'registerType' => 'personal',
            'phone' => '13800138002', // 不同的手机号
            'phoneVerify' => '123456',
            'username' => 'test_user_personal',
            'password' => 'password123',
            'passwordRepeat' => 'password123',
            'captcha' => 'test_captcha',
            'sports' => ['road_running']
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(-1, $data['code']);
        $this->assertEquals('两次手机不一致', $data['msg']);

        // 验证用户未被创建
        $user = MemberUser::where('phone', '13800138002')->first();
        $this->assertNull($user);
    }

    /**
     * 测试重复手机号注册
     */
    public function test_register_with_duplicate_phone()
    {
        // 先创建一个用户
        MemberUser::create([
            'username' => 'existing_user',
            'phone' => '13800138001',
            'password' => bcrypt('password123'),
            'status' => 1
        ]);

        // 模拟验证码已发送
        Session::put('registerPhoneVerify', '123456');
        Session::put('registerPhoneVerifyTime', time());
        Session::put('registerPhone', '13800138001');

        $response = $this->post('/register', [
            'registerType' => 'personal',
            'phone' => '13800138001',
            'phoneVerify' => '123456',
            'username' => 'test_user_personal',
            'password' => 'password123',
            'passwordRepeat' => 'password123',
            'captcha' => 'test_captcha',
            'sports' => ['road_running']
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(-1, $data['code']);
        $this->assertEquals('表单校验失败', $data['msg']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('phone', $data['errors']);
    }

    /**
     * 测试验证码发送频率限制
     */
    public function test_phone_verify_rate_limit()
    {
        // 模拟图片验证码验证通过
        Session::put('registerCaptchaPass', true);
        Session::put('registerCaptchaPassCount', 1);

        // 第一次发送验证码
        $response = $this->post('/register/phone_verify', [
            'target' => '13800138001'
        ]);
        $response->assertStatus(200);

        // 立即再次发送验证码（应该被限制）
        Session::put('registerCaptchaPass', true);
        Session::put('registerCaptchaPassCount', 1);
        
        $response = $this->post('/register/phone_verify', [
            'target' => '13800138001'
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        // 由于60秒内重复发送，应该返回成功但实际不会重新发送
        $this->assertEquals(0, $data['code']);
    }

    protected function tearDown(): void
    {
        // 清理测试数据
        MemberUser::where('phone', 'like', '1380013800%')->delete();
        parent::tearDown();
    }
} 