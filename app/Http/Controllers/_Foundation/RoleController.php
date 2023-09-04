<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Models\_Foundation\Audit;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = Role::select()->with('abilities');

        if ($request->filled('title')) {
            $search = $request->input('title');
            $data->where('title', 'like', "%$search%");
        }

        return new Response($request, $data->paginate($size, ['*'], 'current', $current));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
        ]);

        $role = Role::create([
            'name' => $validated['title'],
            'title' => $validated['title'],
        ]);

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '创建角色',
            'ip' => $request->getClientIp(),
            'model_type' => Role::class,
            'model_id' => $role->id,
            'new' => $role,
        ]);

        return new Response($request, $role);
    }

    public function show(Request $request, Role $role)
    {
        $role = Role::with('abilities')->find($role)->first();
        return new Response($request, $role);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'ability_names' => ['nullable', 'array', 'exists:abilities,name'],
        ]);

        $original = Role::find($role->id);
        $original = [
            ...$original->toArray(),
            'abilities' => $original->getAbilities()->map(function ($item) {
                return $item->title;
            })
        ];

        $role->update([
            'title' => $validated['title'],
        ]);

        $role->disallow($role->getAbilities());

        if ($request->filled('ability_names')) {
            $role->allow($validated['ability_names']);
        }

        $new = [
            ...$role->toArray(),
            'abilities' => $role->getAbilities()->map(function ($item) {
                return $item->title;
            })
        ];

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '修改角色',
            'ip' => $request->getClientIp(),
            'model_type' => Role::class,
            'model_id' => $role->id,
            'old' => $original,
            'new' => $new,
        ]);

        return new Response($request, $role);
    }

    public function destroy(Request $request, Role $role)
    {
        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '删除角色',
            'ip' => $request->getClientIp(),
            'model_type' => Role::class,
            'model_id' => $role->id,
        ]);

        return new Response($request, $role->delete());
    }
}
