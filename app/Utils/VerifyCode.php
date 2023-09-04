<?php

namespace App\Utils;

use App\Exceptions\TencentCloudException;
use App\Service\Tencent\SMSService;
use Illuminate\Support\Facades\Cache;

class VerifyCode
{
    public static function generate(string $mobile, int $length = 4, int $ttl = 5): bool
    {
        $captcha = Cache::get("captcha.$mobile");

        if (!$captcha) {
            $captcha = "";
            for ($i = 0; $i < $length; $i++) {
                $captcha .= rand(0, 9);
            }
        }

        return self::send($mobile, $captcha, $ttl);
    }

    private static function send($mobile, $captcha, $ttl): bool
    {
        $secretId = config('services.tencent-cloud.secret_id');
        $secretKey = config('services.tencent-cloud.secret_key');
        $sdkId = config('services.tencent-cloud.sms.app_id');
        $sign = config('services.tencent-cloud.sms.signature');
        $template = config('services.tencent-cloud.sms.templates.verify');

        $service = new SMSService($sdkId, $sign, $secretId, $secretKey);

        try {
            $service->sendVerifyCode($mobile, $captcha, $ttl, $template);
            Cache::put("captcha.$mobile", $captcha, now()->addMinutes($ttl));
            return true;
        } catch (TencentCloudException) {
            return false;
        }


    }

    public static function check(string $mobile, string $captcha): bool
    {
        $storedCaptcha = Cache::pull("captcha.$mobile");

        return $storedCaptcha == $captcha;
    }
}
