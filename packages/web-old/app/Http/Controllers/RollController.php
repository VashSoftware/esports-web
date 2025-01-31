<?php

namespace App\Http\Controllers;

use App\Events\ParticipantRolled;
use App\Models\MatchParticipant;
use App\Models\Roll;
use App\Services\MatchService;
use Illuminate\Http\Request;

class RollController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MatchService $matchService)
    {
        $validated = $request->validate([
            'match_participant_id' => 'required|exists:match_participants,id',
        ]);

        if (Roll::where('match_participant_id', $validated['match_participant_id'])->exists()) {
            return back(status: 303);
        }

        $roll = rand(1, 100);

        Roll::create([
            'match_participant_id' => $validated['match_participant_id'],
            'roll' => $roll,
        ]);

        $matchParticipant = MatchParticipant::with('vashMatch')->find($validated['match_participant_id']);

        ParticipantRolled::dispatch($validated['match_participant_id']);

        $matchService->checkRolls($matchParticipant->vashMatch->id);

        return back(status: 303);
    }

    /**
     * Display the specified resource.
     */
    public function show(Roll $roll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roll $roll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roll $roll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roll $roll)
    {
        //
    }
}
