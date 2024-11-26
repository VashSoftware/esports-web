<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class MatchQueueController extends Controller
{
    public function join(Request $request)
    {
        $isMember = Redis::sismember('match_queue', $request->user()->profile->personalTeam()->id);
        Log::debug($isMember);

        if (!$isMember) {
            Redis::sadd('match_queue', $request->user()->profile->personalTeam()->id);
        }

        return back(status: 303);
    }

    public function leave(Request $request)
    {
        Redis::srem('match_queue', $request->input('team_id'));

        return back(status: 303);
    }
}
