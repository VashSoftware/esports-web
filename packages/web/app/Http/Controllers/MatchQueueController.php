<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class MatchQueueController extends Controller
{
    public function join(Request $request)
    {
        $teamId = $request->user()->profile->personalTeam()->id;

        $isMember = Redis::exists('match_queue:1v1:'.$teamId);
        Log::debug($isMember);

        if (! $isMember) {
            Redis::hset('match_queue:1v1:'.$teamId, 'team_id', $teamId, 'rating', $request->user()->profile->personalTeam()->ratings->firstWhere('game_id', 1)->rating);
        }

        return back(status: 303);
    }

    public function leave(Request $request)
    {
        $teamId = $request->user()->profile->personalTeam()->id;

        Redis::del('match_queue:1v1:'.$teamId);

        return back(status: 303);
    }
}
