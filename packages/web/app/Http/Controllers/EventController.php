<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Game;
use App\Models\GameMode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Events/Index', ['events' => Event::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Events/Create', ['organisation_members' => Auth::user()->organisationMembers()->with('organisation.eventGroups')->get(), 'games' => Game::with('gameModes')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'organisation_id' => 'required|exists:organisations,id',
            'event_group_id' => 'required|exists:event_groups,id',
            'game_id' => 'required|exists:games,id',
            'game_mode_id' => 'required|exists:game_modes,id',
        ]);

        $organisation = Organisation::find($validated['organisation_id']);

        $event = $organisation->events()->create($validated);

        return redirect()->route('events.show', $event->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Events/Show', ['event' => Event::find($id)]);
    }

    public function manage(string $id)
    {
        return Inertia::render('Events/Manage', [
            'event' => Event::with('teams')->with('rounds')->find($id),
            'games' => Game::all(), 'game_modes' => GameMode::all(),
            'event_groups' => Event::find($id)->organisation->eventGroups()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'nullable',
            'has_qualifier_stage' => 'nullable',
            'has_group_stage' => 'nullable',
        ]);

        $event = Event::find($id);

        $event->update($validated);

        return redirect('events/' . $id . '/manage', 303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
