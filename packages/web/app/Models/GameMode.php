<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
    protected $fillable = [
        'name',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
