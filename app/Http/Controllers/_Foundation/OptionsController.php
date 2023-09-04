<?php

namespace App\Http\Controllers\_Foundation;

use App\Http\Controllers\Controller;
use App\Models\_Foundation\Team;
use App\Models\_Foundation\User;
use App\Utils\Response;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class OptionsController extends Controller
{
    public function abilities(Request $request)
    {
        $data = Ability::select()->whereNot('name', '*')->get();

        return new Response($request, $data);
    }

    public function roles(Request $request)
    {
        $data = Role::select()->get();

        return new Response($request, $data);
    }

    public function users(Request $request)
    {
        $data = User::select(['id', 'name', 'avatar'])
            ->withTrashed()
            ->orderByRaw('name is null, CONVERT(name using GBK) collate gbk_chinese_ci')
            ->get();
        return new Response($request, $data);
    }

    public function teams(Request $request)
    {
        $data = Team::whereNull('parent_id')->get();
        return new Response($request, $data);
    }

}
