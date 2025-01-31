<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MapPoolMap extends Model
{
    use HasFactory;

    public function mapPool(): BelongsTo
    {
        return $this->belongsTo(MapPool::class);
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function mapPoolMapMods(): HasMany
    {
        return $this->hasMany(MapPoolMapMod::class);
    }

    public function matchMaps(): HasMany
    {
        return $this->hasMany(MatchMap::class);
    }
}
