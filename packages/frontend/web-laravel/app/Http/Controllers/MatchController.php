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
        return Inertia::render('Matches/Index', ['matches' => VashMatch::all()]);
    }

    public function store(Request $request)
    {
        $mapPool = MapPool::find($request->input('map_pool_id'));


        $match = VashMatch::create([
            'map_pool_id' => $mapPool->id,
        ]);

        $mapPool->matches()->save($match);
    }
}
