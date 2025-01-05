<?php

namespace App\Events;

use App\Models\MatchMap;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MapPicked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The MatchMap instance.
     *
     * @var \App\Models\MatchMap
     */
    public $matchMap;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\MatchMap $matchMap
     */
    public function __construct(MatchMap $matchMap)
    {
        // Load the necessary relationships
        $this->matchMap = $matchMap->load(['scores.matchParticipantPlayer', 'mapPoolMap.map.mapSet', 'vashMatch']);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'matchMap' => $this->matchMap->toArray(), // Convert to array if necessary
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('match.' . $this->matchMap->vashMatch->id),
        ];
    }
}
