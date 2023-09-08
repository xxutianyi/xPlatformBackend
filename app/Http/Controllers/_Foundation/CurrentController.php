<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Models\_Foundation\Audit;
use App\Models\_Foundation\User;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CurrentController extends Controller
{
    public function show(Request $request)
    {
        $data = [
            'user' => $request->user(),
            'access' => $request->user()->getAccess()
        ];

        return new Response($request, $data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => ['required', Rule::unique('users')->ignore($request->user())],
        ]);

        $original = User::find($request->user()->id);
        $request->user()->update($validated);

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '修改资料：个人信息',
            'ip' => $request->getClientIp(),
            'model_type' => User::class,
            'model_id' => $request->user()->id,
            'old' => $original->toArray(),
            'new' => $request->user(),
        ]);

        return new Response($request, $request->user());
    }

    public function password(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '修改资料：修改密码',
            'ip' => $request->getClientIp(),
        ]);

        return new Response($request);
    }
}
