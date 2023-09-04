<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Jobs\SendInitPasswordJob;
use App\Models\_Foundation\Audit;
use App\Models\User;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = User::select()
            ->orderByRaw('name is null, CONVERT(name using GBK) collate gbk_chinese_ci')
            ->with(['teams', 'roles']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $data->where('name', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%");
        }

        if ($request->filled('name')) {
            $name = $request->string('name');
            $data->where('name', 'like', "%$name%");
        }

        if ($request->filled('email')) {
            $email = $request->string('email');
            $data->where('email', 'like', "%$email%");
        }

        if ($request->filled('mobile')) {
            $mobile = $request->string('mobile');
            $data->where('mobile', 'like', "%$mobile%");
        }

        if ($request->filled('team_id')) {
            $data->whereRelation('teams', 'teams.id', $request->string('team_id'));
        }

        if ($request->filled('only_trashed')) {
            $data->onlyTrashed();
        }

        if ($size && $current) {
            return new Response($request, $data->paginate($size, ['*'], 'current', $current));
        } else {
            return new Response($request, ['data' => $data->get()]);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'mobile' => ['required', Rule::unique('users')],
            'team_ids' => ['required', 'array', 'exists:teams,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'mobile' => $validated['mobile']
        ]);

        $password = Str::password(8);
        $user->password = Hash::make($password);
        $user->save();

        SendInitPasswordJob::dispatchAfterResponse($user->mobile, $password);

        $user->teams()->sync($validated['team_ids']);

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '创建用户',
            'ip' => $request->getClientIp(),
            'model_type' => User::class,
            'model_id' => $user->id,
            'new' => $user,
        ]);

        return new Response($request, $user);
    }

    public function show(Request $request, User $user)
    {
        return new Response($request, $user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'mobile' => ['required', Rule::notIn('users')],
            'team_ids' => ['required', 'array', 'exists:teams,id'],
        ]);

        $original = User::find($user->id);
        $originalTeamIds = $user->teams->map(function ($team) {
            return $team->id;
        });

        $user->name = $validated['name'];
        $user->mobile = $validated['mobile'];

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '修改用户',
            'ip' => $request->getClientIp(),
            'model_type' => User::class,
            'model_id' => $user->id,
            'old' => [...$original->toArray(), 'teams' => $originalTeamIds],
            'new' => [...$user->toArray(), 'teams' => $validated['team_ids']],
        ]);

        $user->save();
        $user->teams()->sync($validated['team_ids']);

        return new Response($request, $user);
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->deleted_at) {
            Audit::create([
                'user_id' => Auth::id(),
                'comment' => '恢复用户',
                'ip' => $request->getClientIp(),
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);

            $user->restore();
        } else {

            Audit::create([
                'user_id' => Auth::id(),
                'comment' => '停用用户',
                'ip' => $request->getClientIp(),
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);

            $user->delete();
        }
        return new Response($request);
    }
}
