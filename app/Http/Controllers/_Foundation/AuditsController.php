<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Models\_Foundation\Audit;
use App\Utils\Response;
use Illuminate\Http\Request;

class AuditsController extends Controller
{
    public function __invoke(Request $request)
    {
        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = Audit::select()->latest();

        if ($request->filled('user_id')) {
            $data->where('user_id', $request->string('user_id'));
        }

        if ($request->filled('created_at')) {
            $data->where('created_at', $request->string('created_at'));
        }

        if ($request->filled('comment')) {
            $comment = $request->string('comment');
            $data->where('comment', 'like', "%$comment%");
        }

        if ($request->filled('ip')) {
            $ip = $request->string('ip');
            $data->where('ip', 'like', "%$ip%");
        }

        return new Response($request, $data->paginate($size, ['*'], 'current', $current));
    }
}
