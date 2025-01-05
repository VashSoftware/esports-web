<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function mapPoolMapMods(): HasMany
    {
        return $this->hasMany(MapPoolMapMod::class);
    }
}
