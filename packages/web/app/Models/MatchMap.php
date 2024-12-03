<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchMap extends Model
{
    use HasFactory;

    protected $fillable = ['map_pool_map_id', 'match_id'];

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function vashMatch(): BelongsTo
    {
        return $this->belongsTo(VashMatch::class);
    }

    public function mapPoolMap(): BelongsTo
    {
        return $this->belongsTo(MapPoolMap::class);
    }
}
