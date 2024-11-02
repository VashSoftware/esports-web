<?php

namespace App\Http\Controllers;

use App\Models\MapPool;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapPoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('MapPools', ['mapPools' => MapPool::all()]);
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
        MapPool::create();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('MapPool', ['mapPool' => MapPool::find($id)]);

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
