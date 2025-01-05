<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapPoolMapMod extends Model
{
    protected $fillable = ['map_pool_map_id', 'mod_id'];

    public function mapPoolMap(): BelongsTo
    {
        return $this->belongsTo(MapPoolMap::class);
    }

    public function mod(): BelongsTo
    {
        return $this->belongsTo(Mod::class);
    }
}
