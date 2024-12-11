<?php

namespace App\Http\Controllers;

use App\Models\MatchBan;
use Illuminate\Http\Request;

class MatchBanController extends Controller
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_id' => 'required',
            'map_pool_map_id' => 'required'
        ]);

        MatchBan::create([
            'vash_match_id' => $validated['match_id'],
            'map_pool_map_id' => $validated['map_pool_map_id']
        ]);

        return back(status: 303);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchBan $matchBan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchBan $matchBan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatchBan $matchBan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchBan $matchBan)
    {
        //
    }
}
