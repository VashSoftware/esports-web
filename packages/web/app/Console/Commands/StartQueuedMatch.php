<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class StartQueuedMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match-queue:start {game_mode_id} {team_size}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Picks the 2 teams in a given game mode queue closest in their rating.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gameModeId = $this->argument('game_mode_id');
        $teamSize = $this->argument('team_size');

        $matchQueue = Redis::keys("match_queue:{$teamSize}v{$teamSize}:*");
        Log::debug($matchQueue);

        if (count($matchQueue) < 2) {
            return;
        }

        $matchups = [];
        foreach ($matchQueue as $team1Key) {
            foreach ($matchQueue as $team2Key) {
                Log::debug($team1Key);

                $team1 = Redis::hgetall($team1Key);
                $team2 = Redis::hgetall($team2Key);

                Log::debug($team1);
                Log::debug($team2);

                if ($team1['team_id'] == $team2['team_id']) {
                    continue;
                }

                $matchups[] = ['team1' => $team1['team_id'], 'team2' => $team2['team_id'], 'rating_difference' => abs($team1['rating'] - $team2['rating'])];
            }
        }

        usort($matchups, function ($a, $b) {
            return $a['rating'] <=> $b['rating'];
        });

        VashMatch::create([
            'map_pool_id' => 1,
        ]);

    }
}
