<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;

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
        return Inertia::render('Events/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $event = Event::create($request->all());

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
        return Inertia::render('Events/Manage', ['event' => Event::with('teams')->with('rounds')->find($id)]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
