<?php

namespace App\Http\Controllers;

use App\Services\OsuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Map;
use App\Models\MapSet;

class MapController extends Controller
{
    protected $osuService;

    public function __construct(OsuService $osuService)
    {
        $this->osuService = $osuService;
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
        ]);

        $query = $validated['query'];

    if (filter_var($query, FILTER_VALIDATE_URL)) {
        if (preg_match('/beatmapsets\/(\d+)(?:#(\w+)\/(\d+))?/', $query, $matches)) {
            $mapsetId = $matches[1] ?? null;
            $mode = $matches[2] ?? null;
            $mapId = $matches[3] ?? null;

            if (!$mapId) {
                return response()->json(['error' => 'Invalid map URL: Map ID missing'], 400);
            }

            $query = $mapId; // Use map ID for further processing
        } else {
            return response()->json(['error' => 'Invalid map URL format'], 400);
        }
    }
        if (is_numeric($query)) {
            if (!Map::where('osu_id', $query)->exists()) {
                $beatmap = $this->osuService->get('beatmaps/' . $query);

                $mapSet = MapSet::where('osu_id', $beatmap['beatmapset_id'])->first();
                if (!$mapSet) {
                    $mapSet = $this->osuService->get('beatmapsets/' . $beatmap['beatmapset_id']);
                    $mapSet = MapSet::create([
                        'artist' => $mapSet['artist'],
                        'title' => $mapSet['title'],
                        'osu_id' => $mapSet['id'],
                    ]);
                }

                $mapSet->maps()->save(new Map([
                    'difficulty_name' => $beatmap['version'],
                    'osu_id' => $beatmap['id'],
                ]));
            }
        }

        $maps = Map::search($query)->query(function ($query) {
            $query->join('map_sets', 'maps.map_set_id', 'map_sets.id')
                ->select(['maps.id as map_id', 'maps.osu_id', 'maps.difficulty_name', 'map_sets.id', 'map_sets.artist', 'map_sets.title']);
        })->get();


        return response()->json($maps);
    }
}
