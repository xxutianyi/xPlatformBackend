<?php

use App\Models\_Foundation\Team;
use App\Models\_Foundation\TeamUser;
use App\Models\_Foundation\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $mobile = "18012345678";
        $password = "18012345678";
        User::create([
            'id' => User::ROOT_ID,
            'name' => '系统用户',
            'mobile' => $mobile,
            'avatar' => '/images/avatar.png',
            'password' => Hash::make($password),
        ]);

        Team::create([
            'id' => Team::ROOT_ID,
            'order' => 0,
            'name' => config('app.name'),
            'path' => config('app.name'),
        ]);

        TeamUser::create([
            'team_id' => Team::ROOT_ID,
            'user_id' => User::ROOT_ID,
            'is_manager' => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TeamUser::where('team_id', Team::ROOT_ID)
            ->where('user_id', User::ROOT_ID)
            ->delete();
        Team::find(Team::ROOT_ID)->delete();
        User::find(User::ROOT_ID)->forceDelete();
    }
};
