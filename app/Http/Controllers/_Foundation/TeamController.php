<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Models\_Foundation\Audit;
use App\Models\_Foundation\Team;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = Team::select()->without('children');

        if ($request->filled('name')) {
            $search = $request->input('name');
            $data->where('name', 'like', "%$search%");
        }

        return new Response($request, $data->paginate($size, ['*'], 'current', $current));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'parent_id' => ['required', 'exists:teams,id'],
        ]);

        $team = Team::create(Team::fillPath($validated));

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '创建团队',
            'ip' => $request->getClientIp(),
            'model_type' => Team::class,
            'model_id' => $team->id,
            'new' => $team,
        ]);

        return new Response($request, $team);
    }

    public function show(Request $request, Team $team)
    {
        return new Response($request, $team);
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'parent_id' => ['required', 'exists:teams,id', Rule::notIn([$team->id]),],
        ]);

        $original = Team::find($team->id);

        $team->update(Team::fillPath($validated));

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '修改团队',
            'ip' => $request->getClientIp(),
            'model_type' => Team::class,
            'model_id' => $team->id,
            'old' => $original->toArray(),
            'new' => $team,
        ]);

        return new Response($request, $team);
    }

    public function destroy(Request $request, Team $team)
    {
        $teamChildren = Team::where('parent_id', $team->id)->get();

        foreach ($teamChildren as $child) {
            $child->update(Team::fillPath(['name' => $child->name, 'parent_id' => $team->parent_id]));
        }

        TeamUser::where('team_id', $team->id)->update(['team_id' => $team->parent_id]);

        $team->delete();

        Audit::create([
            'user_id' => Auth::id(),
            'comment' => '删除团队',
            'ip' => $request->getClientIp(),
            'model_type' => Team::class,
            'model_id' => $team->id,
        ]);

        return new Response($request);
    }
}
