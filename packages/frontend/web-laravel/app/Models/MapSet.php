<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class MapSet extends Model
{
    use HasFactory;
    use Searchable;

    public function maps(): HasMany
    {
        return $this->hasMany(Map::class);
    }
}
