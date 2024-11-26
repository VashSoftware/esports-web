<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MatchQueueController extends Controller
{
    public function join(Request $request)
    {
        Redis::lpush('match_queue', $request->input('team_id'));

        return back(status: 303);
    }

    public function leave(Request $request)
    {
        Redis::rpop('match_queue', $request->input('team_id'));

        return back(status: 303);
    }
}
