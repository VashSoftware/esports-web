<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchParticipantPlayer extends Model
{
    use HasFactory;

    protected $fillable = ['team_member_id', 'match_participant_id', 'in_lobby', 'lobby_slot', 'ready', 'osu_team'];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function matchParticipant(): BelongsTo
    {
        return $this->belongsTo(MatchParticipant::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
