<?php

namespace App\Http\Controllers;

use App\Models\MapPool;
use App\Models\VashMatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index()
    {
        return Inertia::render('Matches/Index', ['matches' => VashMatch::with('matchParticipants')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'round_id' => 'nullable|exists:rounds,id',
            'map_pool_id' => 'required|exists:map_pools,id',
            'match_participants' => 'required|array',
        ]);

        $mapPool = MapPool::find($validated['map_pool_id']);

        $match = $mapPool->vashMatches()->create();

        return redirect('/matches/'.$match->id.'/play', status: 303);
    }

    public function play(VashMatch $match)
    {
        return Inertia::render('Matches/Play', ['match' => $match]);
    }
}
