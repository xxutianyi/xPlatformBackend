<?php

namespace App\Models\_Foundation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasRolesAndAbilities;
    const ROOT_ID = "00000000-0000-0000-0000-000000000000";
    protected $fillable = [
        'id',
        'name',
        'mobile',
        'password',
        'wework_id',
        'avatar'
    ];

    protected $with = [
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public static function findByMobile(string $mobile): User|null
    {
        return User::where('mobile', $mobile)->first();
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->using(TeamUser::class)
            ->withPivot(['is_manager']);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(Audit::class);
    }

    public function getAccess(): array
    {
        $abilities = Ability::select('name')->get();
        $access = [];

        $abilities->map(function (Ability $ability) use (&$access) {
            $accessKey = str_replace(['/', '-'], '_', $ability->getAttribute('name'));
            $access[$accessKey] = $this->can($ability);
        });

        return $access;
    }
}
