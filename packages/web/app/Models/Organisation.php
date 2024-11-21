<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organisation extends Model
{
    use HasFactory;

    public function organisationMembers(): HasMany
    {
        return $this->hasMany(OrganisationMember::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function eventGroups(): HasMany
    {
        return $this->hasMany(EventGroup::class);
    }
}
