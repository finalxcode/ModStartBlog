<?php

namespace Module\Vendor\Admin\Controller;

use Illuminate\Routing\Controller;
use ModStart\Admin\Layout\AdminConfigBuilder;
use ModStart\Form\Form;
use ModStart\Support\Concern\HasFields;
use Module\Vendor\Provider\SmsSender\SmsSenderProvider;
use Module\Vendor\Provider\MailSender\MailSenderProvider;

class ConfigController extends Controller
{
    public function sms(AdminConfigBuilder $builder)
    {
        $builder->pageTitle('短信服务设置');
        $builder->disableBoxWrap(true);
        $builder->formClass('wide');
        
        // 获取所有可用的短信发送服务提供商
        $smsProviders = [];
        foreach (SmsSenderProvider::all() as $provider) {
            $smsProviders[$provider->name()] = $provider->title();
        }
        
        $builder->layoutPanel('短信发送设置', function (Form $builder) use ($smsProviders) {
            /** @var HasFields $builder */
            $builder->select('SmsSenderProvider', '短信发送服务')
                ->options($smsProviders)
                ->help('选择短信发送服务提供商。调试模式下短信不会真实发送，仅记录到日志。')
                ->required();
                
            $builder->switch('SmsSenderDebugMode', '调试模式')
                ->help('开启后，所有短信都会记录到日志但不会真实发送')
                ->defaultValue(config('app.debug', false));
        });
        
        return $builder->perform();
    }
    
    public function email(AdminConfigBuilder $builder)
    {
        $builder->pageTitle('邮件服务设置');
        $builder->disableBoxWrap(true);
        $builder->formClass('wide');
        
        // 获取所有可用的邮件发送服务提供商
        $emailProviders = [];
        foreach (MailSenderProvider::all() as $provider) {
            $emailProviders[$provider->name()] = $provider->name();
        }
        
        $builder->layoutPanel('邮件发送设置', function (Form $builder) use ($emailProviders) {
            /** @var HasFields $builder */
            if (!empty($emailProviders)) {
                $builder->select('EmailSenderProvider', '邮件发送服务')
                    ->options($emailProviders)
                    ->help('选择邮件发送服务提供商');
            } else {
                $builder->display('', '提示')->value('暂无可用的邮件发送服务提供商');
            }
        });
        
        return $builder->perform();
    }
} 