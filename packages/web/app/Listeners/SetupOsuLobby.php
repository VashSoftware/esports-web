<?php

namespace App\Listeners;

use App\Events\OsuLobbyCreated;
use App\Jobs\GetOsuSettings;
use App\Models\MatchParticipantPlayer;
use App\Services\MatchService;
use App\Services\OsuService;

class SetupOsuLobby
{
    /**
     * Create the event listener.
     */
    public function __construct(public MatchService $matchService, public OsuService $osuService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OsuLobbyCreated $event): void
    {
        $this->osuService->setSettings($event->match->id, 2, 3, MatchParticipantPlayer::whereHas('matchParticipant', function ($mp) use ($event) {
            $mp->where('vash_match_id', $event->match->id);
        })->count());

        foreach ($event->match->matchParticipants as $participant) {
            foreach ($participant->matchParticipantPlayers as $player) {
                $this->matchService->inviteMatchPlayer($player->id);
            }
        }

        GetOsuSettings::dispatch($event->match->id);
    }
}
