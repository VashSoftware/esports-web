<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Map extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['difficulty_name', 'osu_id'];

    public function toSearchableArray(): array
    {
        return [
            'osu_id' => '',
            'map_sets.artist' => '',
            'map_sets.title' => '',
            'difficulty_name' => '',
        ];
    }

    public function mapSet(): BelongsTo
    {
        return $this->belongsTo(MapSet::class);
    }

    public function mapPoolMaps(): HasMany
    {
        return $this->hasMany(MapPoolMap::class);
    }
}
