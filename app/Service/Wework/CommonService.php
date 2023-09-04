<?php

namespace App\Service\Wework;

use App\Exceptions\WeworkApiException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use SimpleRequest\Request;

class CommonService
{

    const BASE_URL = "https://qyapi.weixin.qq.com/cgi-bin";
    public string $corpID;
    public string $secret;
    public string $agentID;
    private string $cacheKey;

    public function __construct(string $corpID, string $secret, string $agentID)
    {
        $this->corpID = $corpID;
        $this->secret = $secret;
        $this->agentID = $agentID;
        $this->cacheKey = "wework.access_token.$corpID";
    }

    /**
     * @throws WeworkApiException
     */
    private function handleResponse(string $result): array
    {
        $result = json_decode($result, true);
        if ($result['errcode']) {
            throw new WeworkApiException($result);
        }
        return $result;
    }

    public function GetAccessToken(): string
    {
        $accessToken = Cache::get($this->cacheKey);
        if ($accessToken) {
            return $accessToken;
        } else {
            return $this->RefreshAccessToken();
        }
    }

    /**
     * @throws GuzzleException
     * @throws WeworkApiException
     */
    private function RefreshAccessToken(): string
    {
        $url = self::BASE_URL . "/gettoken";
        $result = Request::get($url, [
            'corpid' => $this->corpID,
            'corpsecret' => $this->secret
        ]);
        $result = $this->handleResponse($result);

        Cache::put($this->cacheKey, $result['access_token'], $result['expires_in']);

        return $result['access_token'];
    }

    /**
     * @throws GuzzleException
     * @throws WeworkApiException
     */
    public function GetUserInfoByCode(string $code): array
    {
        $url = self::BASE_URL . "/auth/getuserinfo";
        $result = Request::get($url, [
            'access_token' => $this->GetAccessToken(),
            'code' => $code,
        ]);

        return $this->handleResponse($result);
    }

    /**
     * @throws GuzzleException
     * @throws WeworkApiException
     */
    public function GetUserDetailByTicket(string $ticket): array
    {
        $url = self::BASE_URL . "/auth/getuserdetail";
        $result = Request::post($url, [
            'access_token' => $this->GetAccessToken(),
        ], [
            'user_ticket' => $ticket
        ]);

        return $this->handleResponse($result);
    }

    /**
     * @throws GuzzleException
     * @throws WeworkApiException
     */
    public function GetExternalContact(string $id): array
    {
        $url = self::BASE_URL . "/externalcontact/get";
        $result = Request::get($url, [
            'access_token' => $this->GetAccessToken(),
            'external_userid' => $id
        ]);

        return $this->handleResponse($result);
    }


    /**
     * @throws GuzzleException
     * @throws WeworkApiException
     */
    public function GetChatRoom(string $id): array
    {
        $url = self::BASE_URL . "/externalcontact/groupchat/get";
        $result = Request::post($url, [
            'access_token' => $this->GetAccessToken(),
        ], [
            'chat_id' => $id,
        ]);

        return $this->handleResponse($result);
    }
}
