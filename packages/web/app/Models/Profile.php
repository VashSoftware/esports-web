<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Profile extends Model
{
    protected $fillable = ['username', 'display_name', 'profile_picture'];

    public function user(): HasOne {
        return $this->hasOne(User::class);
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

    public function personalTeam(){
        return $this->teamMembers()->firstWhere('team.personal_team', true)->team();
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

}
