<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Response extends JsonResponse
{

    public function __construct(Request $request, $data = null, string $message = "success", ShowType $showType = ShowType::SILENT, int $status = 200, $headers = [])
    {

        $success = (bool)($status == 200 | $status == 201);
        $host = config('app.host');

        $response = [
            'success' => $success,
            'errorCode' => $status,
            'errorMessage' => $message,
            'showType' => $showType,
            'traceId' => $request->input('traceId'),
            'host' => $host,
            'data' => $data,
        ];

        parent::__construct($response, 200, $headers);
    }
}
