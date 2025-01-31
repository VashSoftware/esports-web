<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchBan extends Model
{
    protected $fillable = ['vash_match_id', 'map_pool_map_id'];

    public function match(): BelongsTo
    {
        return $this->belongsTo(VashMatch::class);
    }

    public function MapPoolMap(): BelongsTo
    {
        return $this->belongsTo(MapPoolMap::class);
    }
}
