<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileVerifyRequest;
use App\Http\Requests\Auth\PasswordRequest;
use App\Models\_Foundation\Audit;
use App\Models\_Foundation\User;
use App\Service\Wework\CommonService;
use App\Utils\Response;
use App\Utils\VerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function password(PasswordRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '用户登录：密码登录',
            'ip' => $request->getClientIp(),
        ]);

        return new Response($request, Auth::user());
    }

    public function mobileVerify(MobileVerifyRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '用户登录：短信验证登录',
            'ip' => $request->getClientIp(),
        ]);

        return new Response($request, Auth::user());
    }

    public function verifyCode(Request $request, string $mobile)
    {
        return new Response($request, VerifyCode::generate($mobile));
    }

    public function destroy(Request $request)
    {
        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '用户登录：退出账号',
            'ip' => $request->getClientIp(),
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return new Response($request);
    }

    public function wework(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required'
        ]);

        $wework = new CommonService(
            config('services.wework.corp_id'),
            config('services.wework.app.secret'),
            config('services.wework.app.id')
        );

        $userInfo = $wework->GetUserInfoByCode($validated['code']);

        if (key_exists('userid', $userInfo)) {
            $user = User::firstOrCreate(['wework_id' => $userInfo['userid']]);

            Auth::login($user);
        }

        if (key_exists('userid', $userInfo) && key_exists('user_ticket', $userInfo)) {

            $userDetail = $wework->GetUserDetailByTicket($userInfo['user_ticket']);
            $user = User::firstOrCreate(['wework_id' => $userInfo['userid']]);
            $user->update([
                'mobile' => $userDetail['mobile'],
                'avatar' => $userDetail['avatar'],
            ]);

            Auth::login($user);
        }


        Audit::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'comment' => '用户登录：企业微信登录',
            'ip' => $request->getClientIp(),
        ]);

        return new Response($request, Auth::user());
    }
}
