<?php

use App\Models\_Foundation\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'ROOT_ROLE',
            'title' => '管理员（所有权限）',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'DEFAULT_ROLE',
            'title' => '默认（无权限）',
        ]);

        $teamAdmin = Bouncer::role()->firstOrCreate([
            'name' => 'manager',
            'title' => '团队管理员',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/all-team',
            'title' => '管理组织架构',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/access',
            'title' => '管理角色权限',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/audits',
            'title' => '查看审计日志',
        ]);

        $manageTeam = Bouncer::ability()->firstOrCreate([
            'name' => 'manage/my-team',
            'title' => '管理所在团队',
        ]);

        Bouncer::allow($admin)->everything();
        Bouncer::assign($admin)->to(User::find(User::ROOT_ID));

        Bouncer::allow($teamAdmin)->to($manageTeam);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
