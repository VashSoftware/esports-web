<?php

namespace App\Http\Controllers;

use App\Events\OsuLobbyCreated;
use App\Models\OsuMessage;
use App\Models\VashMatch;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'channel' => 'required',
            'message' => 'required',
        ]);

        if ($validated['username'] === 'BanchoBot' && str_contains($validated['message'], 'Created the tournament match')) {
            $pattern = '/Created the tournament match https:\/\/osu\.ppy\.sh\/mp\/(\d+)\s+(.+)/';

            if (preg_match($pattern, $validated['message'], $matches)) {
                $lobbyId = $matches[1];
                $title = $matches[2];

                if (preg_match('/^VASH:\s*\((.*?)\)\s*vs\s*\((.*?)\)$/', $title, $teamMatches)) {
                    $teamA = $teamMatches[1];
                    $teamB = $teamMatches[2];

                    $vashMatch = VashMatch::whereNull('osu_lobby')
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
                        ->first();

                    if ($vashMatch) {
                        $vashMatch->update(['osu_lobby' => $lobbyId]);

                        OsuLobbyCreated::dispatch($vashMatch);
                    }
                }
            }
        }

        OsuMessage::create($validated);
    }

    /**
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
