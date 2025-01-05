<?php

namespace App\Services;

use App\Events\MapPicked;
use App\Events\NewMatch;
use App\Models\MatchMap;
use App\Models\MatchParticipantPlayer;
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
        $match = null;

        DB::transaction(function () use ($mapPoolId, $teams, $bans_per_team, &$match, &$playerIds) {
            $match = VashMatch::create([
                'map_pool_id' => $mapPoolId,
                'bans_per_team' => $bans_per_team,
                'is_rolling' => true,
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

            $this->osuService->makeOsuLobby($match->id);

            foreach ($matchParticipants as $participant) {
                foreach ($participant->team->teamMembers as $member) {
                    $player = $participant->matchParticipantPlayers()->create([
                        'team_member_id' => $member->id,
                    ]);
                }
            }

            NewMatch::dispatch($match);
        });

        //        $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, 'Welcome to Vash Esports!');
        //        $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, 'Please pick a map on the website to get started.');
        //        $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, 'Current rating: 0');

        return $match;
    }

    public function checkRolls(int $matchId)
    {
        $match = VashMatch::find($matchId);

        // Check if all participants have rolled
        foreach ($match->matchParticipants as $participant) {
            if (! $participant->roll) {
                return;
            }
        }

        // Determine the participant with the highest roll
        $participants = $match->matchParticipants;
        $highestRoll = 0;
        $highestRollers = []; // Array to handle ties

        foreach ($participants as $participant) {
            if ($participant->roll->roll > $highestRoll) {
                $highestRoll = $participant->roll->roll;
                $highestRollers = [$participant];
            } elseif ($participant->roll->roll === $highestRoll) {
                $highestRollers[] = $participant;
            }
        }

        // Handle ties
        if (count($highestRollers) === 1) {
            $currentPicker = $highestRollers[0]->id;
        } else {
            $currentPicker = $highestRollers[array_rand($highestRollers)]->id;
        }

        // Update match
        $match->update([
            'is_rolling' => false,
            'current_picker' => $currentPicker,
        ]);
    }

    public function setCurrentMap(VashMatch $match)
    {
        $lastMatchMap = $match->matchMaps()->latest()->first();

        if (! $lastMatchMap) {
            return;
        }

        $this->pickMap($match->id, $lastMatchMap->id);
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

            $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, '!mp map '.$matchMap->mapPoolMap->map->osu_id.' '.$matchMap->mapPoolMap->map->playmode);

            MapPicked::dispatch($matchMap);
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

        $this->osuService->sendIRCMessage($match->osu_lobby, '!mp close');
    }

    public function inviteMatchPlayer(MatchParticipantPlayer $matchParticipantPlayer)
    {
        $playerOsuName = $matchParticipantPlayer->teamMember->profile->platforms()->where('platforms.name', 'osu!')->first()->pivot->name;

        Log::info('Inviting match participant ID: '.$matchParticipantPlayer->id.' to osu! lobby: '.'#mp_'.$matchParticipantPlayer->matchParticipant->vashMatch->osu_lobby);

        $this->osuService->sendIRCMessage('#mp_'.$matchParticipantPlayer->matchParticipant->vashMatch->osu_lobby, '!mp invite '.$playerOsuName);
    }

    public function invitePlayers() {}

    public function resetOsuLobby(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, '!mp close');

        $match->update([
            'osu_lobby' => null,
        ]);

        $this->osuService->makeOsuLobby($match->id);
    }
}
