<?php

namespace App\Service\Tencent;

use App\Exceptions\TencentCloudException;
use TencentCloud\Common\Credential;
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Sms\V20210111\SmsClient;

class SMSService
{
    private Credential $credential;
    private SmsClient $smsClient;
    private SendSmsRequest $sendSmsRequest;
    private string $appId;
    private string $sign;

    public function __construct($appId, $sign, $secretId, $secretKey)
    {
        $this->credential = new Credential($secretId, $secretKey);
        $this->smsClient = new SmsClient($this->credential, "ap-guangzhou");
        $this->sendSmsRequest = new SendSmsRequest();

        $this->appId = $appId;
        $this->sign = $sign;
    }

    /**
     * @throws TencentCloudException
     */
    public function sendPassword(string $mobile, string $password, string $template): array
    {
        $appName = config('app.name');

        $this->sendSmsRequest->SmsSdkAppId = $this->appId;
        $this->sendSmsRequest->SignName = $this->sign;
        $this->sendSmsRequest->TemplateId = $template;
        $this->sendSmsRequest->TemplateParamSet = array($appName, $password);
        $this->sendSmsRequest->PhoneNumberSet = array($mobile);
        $response = $this->smsClient->SendSms($this->sendSmsRequest);

        return $this->handleResponse($response->toJsonString());
    }

    /**
     * @throws TencentCloudException
     */
    public function sendVerifyCode(string $mobile, string $code, string $expire, string $template): array
    {

        $this->sendSmsRequest->SmsSdkAppId = $this->appId;
        $this->sendSmsRequest->SignName = $this->sign;
        $this->sendSmsRequest->TemplateId = $template;
        $this->sendSmsRequest->TemplateParamSet = array($code, $expire);
        $this->sendSmsRequest->PhoneNumberSet = array($mobile);
        $response = $this->smsClient->SendSms($this->sendSmsRequest);

        return $this->handleResponse($response->toJsonString());
    }

    /**
     * @throws TencentCloudException
     */
    private function handleResponse(string $result): array
    {
        $result = json_decode($result, true);
        if (key_exists('Error', $result)) {
            throw new TencentCloudException($result);
        }
        return $result;
    }
}
