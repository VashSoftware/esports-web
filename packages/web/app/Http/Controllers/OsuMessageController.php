<?php

namespace App\Http\Controllers;

use App\Events\OsuLobbyCreated;
use App\Models\OsuLobbyState;
use App\Models\OsuMessage;
use App\Models\VashMatch;
use App\Services\MatchService;
use Illuminate\Http\Request;

class OsuMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request, MatchService $matchService)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'username' => 'required',
            'channel' => 'required',
            'message' => 'required',
        ]);

        // Create the OsuMessage
        $osuMessage = OsuMessage::create($validated);

        // Handle tournament match creation
        if ($validated['username'] === 'BanchoBot' && str_contains($validated['message'], 'Created the tournament match')) {
            $pattern = '/Created the tournament match https:\/\/osu\.ppy\.sh\/mp\/(\d+)\s+(.+)/';

            if (preg_match($pattern, $validated['message'], $matches)) {
                $lobbyId = $matches[1];
                $title = $matches[2];

                if (preg_match('/^VASH:\s*\((.*?)\)\s*vs\s*\((.*?)\)$/', $title, $teamMatches)) {
                    $teamA = $teamMatches[1];
                    $teamB = $teamMatches[2];

                    // Fetch all active VashMatches (where 'osu_lobby' is null and 'finished_at' is null)
                    $activeVashMatches = VashMatch::whereNull('osu_lobby')
                        ->whereNull('finished_at')
                        ->whereHas('matchParticipants', function ($q) use ($teamA) {
                            $q->whereHas('team', function ($t) use ($teamA) {
                                $t->where('name', $teamA);
                            });
                        })
                        ->whereHas('matchParticipants', function ($q) use ($teamB) {
                            $q->whereHas('team', function ($t) use ($teamB) {
                                $t->where('name', $teamB);
                            });
                        })
                        ->get();

                    foreach ($activeVashMatches as $vashMatch) {
                        $vashMatch->update(['osu_lobby' => $lobbyId]);
                        OsuLobbyCreated::dispatch($vashMatch);
                    }
                }
            }
        }

        // Handle ongoing mp_ events
        if (
            $validated['username'] === 'BanchoBot' &&
            preg_match('/^#mp_(\d+)$/', $validated['channel'], $matchChannel)
        ) {
            $lobbyId = (int) $matchChannel[1];
            $vashMatch = VashMatch::where('osu_lobby', $lobbyId)->first();
            if (! $vashMatch) {
                return;
            }

            $osuLobbyState = OsuLobbyState::where('vash_match_id', $vashMatch->id)
                ->where('finalized', false)
                ->latest('created_at')
                ->first();

            if (! $osuLobbyState) {
                $osuLobbyState = OsuLobbyState::create([
                    'vash_match_id' => $vashMatch->id,
                    'finalized' => false,
                ]);
            }

            $osuMessage->update(['osu_lobby_state_id' => $osuLobbyState->id]);

            if (! $osuLobbyState->isComplete()) {
                return;
            }

            $matchService->finalizeLobbyState($vashMatch);

        }
    }

    /**
     * Other controller methods (show, edit, update, destroy) remain unchanged.
     */ /**
     * Display the specified resource.
     */
    public function show(OsuMessage $osuMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OsuMessage $osuMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OsuMessage $osuMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OsuMessage $osuMessage)
    {
        //
    }
}
