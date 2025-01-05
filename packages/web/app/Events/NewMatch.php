<?php

namespace App\Events;

use App\Models\VashMatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public VashMatch $match)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $profileIds = [];
        foreach ($this->match->matchParticipants as $participant) {
            foreach ($participant->matchParticipantPlayers as $player) {
                $profileIds[] = $player->teamMember->profile->id;
            }
        }

        return array_map(function ($profileId) {
            return new Channel('profile.'.$profileId);
        }, $profileIds);
    }
}
