<?php

namespace App\Models\_Foundation;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{
    protected $fillable = [
        'user_id',
        'team_id',
        'is_manager',
    ];
}
