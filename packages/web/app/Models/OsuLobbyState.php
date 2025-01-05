<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class OsuLobbyState extends Model
{
    protected $fillable = ['finalized', 'vash_match_id'];

    public function vashMatch(): BelongsTo
    {
        return $this->belongsTo(VashMatch::class);
    }

    public function osuMessages(): HasMany
    {
        return $this->hasMany(OsuMessage::class);
    }

    public const REQUIRED_MESSAGE_TYPES = [
        'Room name',
        'Team mode',
        'Players',
    ];

    /**
     * Determine if the lobby state is complete.
     *
     * A lobby state is complete if it contains all required message types
     * and the number of "Slot X" messages matches the "Players: X" count.
     */
    public function isComplete(): bool
    {
        $receivedTypes = [];

        // Fetch all messages ordered by creation time
        $messages = $this->osuMessages()->orderBy('created_at')->get();

        foreach ($messages as $message) {
            $trimmedMessage = trim($message->message);
            foreach (self::REQUIRED_MESSAGE_TYPES as $type) {
                if (str_starts_with(strtolower($trimmedMessage), strtolower($type))) {
                    $receivedTypes[$type] = true;
                }
            }
        }

        foreach (self::REQUIRED_MESSAGE_TYPES as $type) {
            if (! isset($receivedTypes[$type])) {
                return false;
            }
        }

        // Retrieve the latest "Players: X" message
        $playersMessage = $this->osuMessages()
            ->where('message', 'like', 'Players:%')
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $playersMessage) {
            // This should not happen as "Players" is already checked
            return false;
        }

        // Extract the number of players from "Players: X"
        if (preg_match('/^Players:\s+(\d+)$/', $playersMessage->message, $matches)) {
            $playersCount = (int) $matches[1];
        } else {
            // Invalid format for "Players: X" message
            return false;
        }

        // Count the number of "Slot X" messages
        $slotCount = $this->osuMessages()->where('message', 'like', 'Slot%')->count();

        // Compare the slot count with the players count
        return $slotCount >= $playersCount;
    }
}
