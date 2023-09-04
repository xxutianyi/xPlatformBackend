<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Utils\Response;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function wework(Request $request)
    {
        $config = [
            'corpId' => config('services.wework.corp_id'),
            'agentId' => config('services.wework.app.id'),
        ];

        return new Response($request, $config);
    }
}
