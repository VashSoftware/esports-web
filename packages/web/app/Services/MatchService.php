<?php

namespace App\Services;

use App\Models\VashMatch;
use App\Services\OsuService;

class MatchService
{
    protected OsuService $osuService;

    public function __construct(OsuService $osuService)
    {
        $this->osuService = $osuService;
    }

    public function createMatch(int $mapPoolId, array $teams)
    {
        $match = VashMatch::create([
            'map_pool_id' => $mapPoolId,
        ]);

        $matchParticipants = $match->matchParticipants()->createMany([
            [
                'team_id' => $teams[0],
            ],
            [
                'team_id' => $teams[1],
            ],
        ]);

        foreach ($matchParticipants as $participant) {
            foreach ($participant->team->teamMembers as $member) {
                $participant->matchParticipantPlayers()->create([
                    'team_member_id' => $member->id,
                ]);
            }
        }
    }

    public function createOsuLobby()
    {
        $this->osuService->sendIRCMessage('BanchoBot', '!mp make 0 0 2');
    }

    public function endMatch(string $osuLobbyName)
    {
        $this->osuService->sendIRCMessage($osuLobbyName, '!mp close');
    }

    public function invitePlayer(string $osuLobbyName, string $username)
    {
        $this->osuService->sendIRCMessage($osuLobbyName, '!mp invite ' . $username);
    }

    public function invitePlayers() {}
}
