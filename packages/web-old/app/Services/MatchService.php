<?php

namespace App\Services;

use App\Events\MapPicked;
use App\Events\MatchParticipantPlayerUpdated;
use App\Events\NewMatch;
use App\Events\NewPicker;
use App\Models\MatchMap;
use App\Models\MatchParticipantPlayer;
use App\Models\OsuLobbyState;
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
                        'ready' => false,
                        'in_lobby' => false,
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
            $currentPicker = $highestRollers[0];
        } else {
            $currentPicker = $highestRollers[array_rand($highestRollers)];
        }

        // Update match
        $match->update([
            'is_rolling' => false,
            'current_picker' => $currentPicker->id,
            'action_limit' => now()->addMinute(),
        ]);

        NewPicker::dispatch($currentPicker);
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
        $matchMap = null;

        DB::transaction(function () use ($matchId, $mapPoolMapId, &$matchMap) { // Note the &
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

            $this->osuService->sendIRCMessage(
                '#mp_'.$match->osu_lobby,
                '!mp map '.$matchMap->mapPoolMap->map->osu_id.' '.$matchMap->mapPoolMap->map->playmode
            );

            $modCodes = $matchMap->mapPoolMap->mapPoolMapMods->map(function ($mapPoolMapMod) {
                return $mapPoolMapMod->mod->code;
            })->toArray();
            $modCodes[] = 'NF';
            $modsString = implode(' ', $modCodes);
            $this->osuService->sendIRCMessage(
                '#mp_'.$match->osu_lobby,
                '!mp mods '.$modsString
            );

            broadcast(new MapPicked($matchMap))->toOthers();
            NewPicker::dispatch($nextPicker);
        });

    }

    public function startMatchMap(MatchMap $matchMap)
    {
        $this->osuService->sendIRCMessage('#mp_'.$matchMap->vashMatch->osu_lobby, '!mp start 5');

        $matchMap->update([
            'started_at' => now(),
        ]);

        foreach ($matchMap->vashMatch->matchParticipants as $participant) {
            foreach ($participant->matchParticipantPlayers as $player) {

            }
        }
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

        $this->osuService->sendIRCMessage('#mp_'.$match->osu_lobby, '!mp close');
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

    public function finalizeLobbyState(VashMatch $vashMatch)
    {
        // grab the most recent NON-finalized state that we just turned "finalized"
        // (or you could do a slightly different lookup if you store multiple states)
        $osuLobbyState = OsuLobbyState::where('vash_match_id', $vashMatch->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $osuLobbyState) {
            return;
        }

        // parse all lines
        $usersInLobby = [];
        $userReadiness = [];

        foreach ($osuLobbyState->osuMessages as $msg) {
            if (preg_match(
                '/^Slot\s+(\d+)\s+(Ready|Not Ready)\s+https:\/\/osu\.ppy\.sh\/u\/(\d+)\s+(.*?)\s+\[(Team [A-Za-z]+)\]/',
                $msg->message,
                $m
            )) {
                $slot = $m[1];
                $readyText = $m[2];
                $osuUserId = $m[3];
                $username = $m[4]; // e.g. "Stan"
                $team = $m[5]; // e.g. "Team Blue"

                // track they’re in the lobby
                $usersInLobby[$osuUserId] = [
                    'username' => $username,
                    'team' => $team,
                    'slot' => $slot,
                ];
                // track readiness
                $userReadiness[$osuUserId] = ($readyText === 'Ready');
            }
        }

        // now update all match participant players
        $allPlayers = $vashMatch->matchParticipants
            ->flatMap->matchParticipantPlayers;

        foreach ($allPlayers as $player) {
            // figure out that player's osu user id
            $playerOsuId = $player->teamMember
                ->profile
                ->platforms()
                ->where('platforms.name', 'osu!')
                ->first()
                ->pivot
                ->id;

            // if we have an entry for that user, they're in-lobby (could be multiple participants with same ID!)
            if (isset($usersInLobby[$playerOsuId])) {
                $player->update([
                    'in_lobby' => true,
                    'ready' => $userReadiness[$playerOsuId],
                    'osu_team' => $usersInLobby[$playerOsuId]['team'],
                    'lobby_slot' => $usersInLobby[$playerOsuId]['slot'],
                ]);
            } else {
                // no mention = not in-lobby
                $player->update([
                    'in_lobby' => false,
                    'ready' => false,
                    'osu_team' => null,
                    'lobby_slot' => null,
                ]);
            }

            MatchParticipantPlayerUpdated::dispatch($player);
        }

        $allPlayers = $vashMatch->matchParticipants
        ->flatMap->matchParticipantPlayers;

        $allReady = $allPlayers->every(function ($player) {
            return $player->in_lobby && $player->ready;
        });

        if ($allReady) {
            $this->startMatchMap($vashMatch->matchMaps()->latest()->first());
        }

        $osuLobbyState->update([
            'finalized' => true,
        ]);
    }
}
