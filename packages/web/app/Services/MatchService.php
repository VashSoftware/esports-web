<?php

namespace App\Services;

use App\Models\VashMatch;

class MatchService
{
    protected OsuService $osuService;

    public function __construct(OsuService $osuService)
    {
        $this->osuService = $osuService;
    }

    public function createMatch(int $mapPoolId, array $teams, int $bans_per_team)
    {
        $match = VashMatch::create([
            'map_pool_id' => $mapPoolId,
            'bans_per_team' => $bans_per_team,
        ]);

        $matchParticipants = $match->matchParticipants()->createMany([
            [
                'team_id' => $teams[0],
                'index' => 1,
            ],
            [
                'team_id' => $teams[1],
                'index' => 2,
            ],
        ]);

        $this->setBanner($match->id, $matchParticipants->random()->id);

        foreach ($matchParticipants as $participant) {
            foreach ($participant->team->teamMembers as $member) {
                $participant->matchParticipantPlayers()->create([
                    'team_member_id' => $member->id,
                ]);
            }
        }

        return $match;
    }

    public function setBanner(int $matchId, int $participantId)
    {
        VashMatch::find($matchId)->update([
            'banning_participant_id' => $participantId,
        ]);
    }

    public function endBanning(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $match->current_banning_participant_id = null;

        $match->save();
    }

    public function addParticipantPlayer() {}

    public function removeParticipantPlayer() {}

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
        $this->osuService->sendIRCMessage($osuLobbyName, '!mp invite '.$username);
    }

    public function invitePlayers() {}
}
