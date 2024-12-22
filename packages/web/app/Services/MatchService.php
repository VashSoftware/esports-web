<?php

namespace App\Services;

use App\Models\MatchMap;
use App\Models\Score;
use App\Models\VashMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function pickMap(int $matchId, int $mapPoolMapId)
    {
        DB::transaction(function () use ($matchId, $mapPoolMapId) {
            $matchMap = MatchMap::create([
                'vash_match_id' => $matchId,
                'map_pool_map_id' => $mapPoolMapId,
            ]);
            Log::debug($matchMap->id);

            $match = VashMatch::with('matchParticipants.matchParticipantPlayers')->findOrFail($matchId);

            foreach ($match->matchParticipants as $participant) {
                foreach ($participant->matchParticipantPlayers as $player) {
                    $score = new Score([
                        'score' => 0,
                        'match_map_id' => $matchMap->id,
                    ]);

                    $player->scores()->save($score);
                }
            }

            $participants = $match->matchParticipants->sortBy('id')->values();

            $currentPickerId = $match->current_picker;

            $currentIndex = $participants->search(function ($participant) use ($currentPickerId) {
                return $participant->id === $currentPickerId;
            });

            if ($currentIndex === false || $currentIndex === $participants->count() - 1) {
                $nextPicker = $participants->first();
            } else {
                $nextPicker = $participants->get($currentIndex + 1);
            }

            $matchMap->vashMatch()->update([
                'action_limit' => now()->addMinute(),
                'current_picker' => $nextPicker->id,
            ]);

        });
    }

    public function addParticipantPlayer() {}

    public function removeParticipantPlayer() {}

    public function createOsuLobby()
    {
        $this->osuService->sendIRCMessage('BanchoBot', '!mp make 0 0 2');
    }

    public function endMatch(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $this->osuService->sendIRCMessage($match->lobby_name, '!mp close');
    }

    public function invitePlayer(string $osuLobbyName, string $username)
    {
        $this->osuService->sendIRCMessage($osuLobbyName, '!mp invite '.$username);
    }

    public function invitePlayers() {}
}
