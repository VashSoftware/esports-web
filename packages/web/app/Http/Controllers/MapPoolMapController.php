<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\MapPool;
use App\Models\MapPoolMap;
use App\Models\MapSet;
use App\Models\Mod;
use App\Services\OsuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MapPoolMapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'map_pool_id' => 'required|exists:map_pools,id',
        ]);

        $mapPool = MapPool::find($validated['map_pool_id']);

        $mapPool->mapPoolMaps()->create();

        return redirect()->route('map_pools.edit', $mapPool);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
            'map_pool_map_id' => 'required|exists:map_pool_maps,id',
            'map_id' => 'required',
        ]);

        $map = Map::find($validated['map_id']);
        if (!$map) {
            $osuService = new OsuService();
            $mapData = $osuService->get("beatmaps/$validated[map_id]");
            Log::info($mapData);

            $mapset = MapSet::find();

            $map = Map::create([
                'name' => $validated['map_id'],
            ]);
        }

        $mapPoolMap = MapPoolMap::find($validated['map_pool_map_id']);
        $mapPoolMap->map_id = $validated['map_id'];

        $mapPoolMap->save();

        return redirect()->route('map_pools.edit', $validated['map_pool_id']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
