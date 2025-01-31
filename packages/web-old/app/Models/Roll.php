<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    protected $fillable = ['roll', 'match_participant_id'];

    public function matchParticipant(): HasOne
    {
        return $this->hasOne(MatchParticipant::class);
    }
}
