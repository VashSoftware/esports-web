<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OsuMessage extends Model
{
    protected $fillable = ['username', 'channel', 'message', 'osu_lobby_state_id'];

    public function osuLobbyState(): BelongsTo
    {
        return $this->belongsTo(OsuLobbyState::class);
    }
}
