<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VashMatch extends Model
{
    use HasFactory;

    protected $fillable = ['finished_at', 'osu_lobby', 'map_pool_id', 'bans_per_team', 'current_banner', 'current_picker', 'action_limit'];

    public function mapPool(): BelongsTo
    {
        return $this->belongsTo(MapPool::class);
    }

    public function matchMaps(): HasMany
    {
        return $this->hasMany(MatchMap::class);
    }

    public function matchParticipants(): HasMany
    {
        return $this->hasMany(MatchParticipant::class);
    }
}
