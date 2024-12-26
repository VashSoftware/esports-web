<?php

namespace App\Http\Controllers;

use App\Models\OsuMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::debug($request);

        $validated = $request->validate([
            'username' => 'required',
            'channel' => 'required',
            'message' => 'required',
        ]);

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
