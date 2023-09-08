<?php

namespace App\Models\_Foundation;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audit extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'comment',
        'ip',
        'old',
        'new'
    ];

    protected $with = [
        'user',
        'model'
    ];

    protected $casts = [
        'old' => 'json',
        'new' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
