<?php

namespace App\Events;

use App\Models\MatchParticipant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantRolled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $matchParticipant;

    /**
     * Create a new event instance.
     */
    public function __construct(int $participantId)
    {
        $this->matchParticipant = MatchParticipant::with(['vashMatch', 'roll'])->find($participantId);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('match.'.$this->matchParticipant->vashMatch->id),
        ];
    }
}
