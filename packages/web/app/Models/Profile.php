<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Profile extends Model
{
    protected $fillable = ['username', 'display_name', 'profile_picture', 'banned_at'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class)->withPivot('id', 'name');
    }

    public function badges(): MorphMany
    {
        return $this->morphMany(Badge::class, 'badgeable');
    }

    public function organisationMembers(): HasMany
    {
        return $this->hasMany(OrganisationMember::class);
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function personalTeam(): ?Team
    {
        return Team::whereHas('teamMembers', function (Builder $query) {
            $query->where('profile_id', $this->id);
        })->where('is_personal_team', true)->first();
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
