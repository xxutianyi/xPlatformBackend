<?php

namespace App\Models\_Foundation;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasUuids;

    const ROOT_ID = "00000000-0000-0000-0000-000000000000";

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'order',
        'path',
    ];

    protected $with = [
        'children'
    ];

    public static function fillPath(array $attributes = []): array
    {
        $path = $attributes['name'];

        $parent_id = $attributes['parent_id'];

        while ($parent_id) {
            $parent = Team::find($parent_id);
            $path = $parent->name . "/" . $path;
            $parent_id = $parent->parent_id;
        }

        $attributes['path'] = $path;

        return $attributes;
    }


    public function children(): HasMany
    {
        return $this->hasMany(Team::class, 'parent_id', 'id');

    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function managers(): Collection
    {
        return $this->users()->wherePivot('is_manager', true)->get();
    }
}
