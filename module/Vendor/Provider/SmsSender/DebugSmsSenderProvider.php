<?php

namespace Module\Vendor\Provider\SmsSender;

use ModStart\Core\Util\SerializeUtil;
use Module\Vendor\Log\Logger;
use Module\Vendor\Provider\SmsTemplate\SmsTemplateProvider;
use Module\Vendor\Util\SmsUtil;

/**
 * 调试模式短信发送提供商
 * 在开发环境下使用，将短信内容记录到日志而不真正发送
 */
class DebugSmsSenderProvider extends AbstractSmsSenderProvider
{
    public function name()
    {
        return 'debug';
    }

    public function title()
    {
        return '调试模式 (仅记录日志)';
    }

    public function send($phone, $template, $templateData, $param = [])
    {
        // 获取模板信息
        $templateMap = SmsTemplateProvider::map();
        $templateInfo = isset($templateMap[$template]) ? $templateMap[$template] : null;
        
        // 解析短信内容
        if ($templateInfo && isset($templateInfo['example'])) {
            $content = SmsUtil::parseContent($templateInfo['example'], $templateData);
        } else {
            // 如果没有找到模板，生成一个默认的内容
            $content = "验证码: " . (isset($templateData['code']) ? $templateData['code'] : '无验证码');
        }

        // 记录到日志
        $logData = [
            'phone' => $phone,
            'template' => $template,
            'templateData' => $templateData,
            'content' => $content,
            'mode' => 'debug'
        ];
        
        Logger::info('Sms', 'Debug Send', SerializeUtil::jsonEncode($logData, JSON_UNESCAPED_UNICODE));

        // 返回成功响应 - 简化为数组格式
        return [
            'code' => 0,
            'msg' => '短信发送成功 (调试模式)',
            'data' => [
                'phone' => $phone,
                'content' => $content,
                'template' => $template
            ]
        ];
    }
} 