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

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/team',
            'title' => '管理团队',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/user',
            'title' => '管理用户',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/access',
            'title' => '管理角色权限',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage/audits',
            'title' => '查看审计日志',
        ]);

        Bouncer::allow($admin)->everything();
        Bouncer::assign($admin)->to(User::find(User::ROOT_ID));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
