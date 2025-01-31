<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['score', 'match_map_id', 'match_participant_player_id'];

    public function matchParticipantPlayer(): BelongsTo
    {
        return $this->belongsTo(MatchParticipantPlayer::class);
    }

    public function matchMap(): BelongsTo
    {
        return $this->belongsTo(MatchMap::class);
    }
}
