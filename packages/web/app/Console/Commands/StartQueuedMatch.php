<?php

namespace App\Console\Commands;

use App\Models\MapPool;
use App\Models\VashMatch;
use Illuminate\Console\Command;
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

    private function getMatchingMapPool($matchParticipants)
    {
        $ratings = array_map(fn ($matchParticipant) => $matchParticipant->team->rating);
        $avgRating = array_sum($ratings) / count($ratings);

        $mapPool = MapPool::where('verified', true)->orderBy('rating')->first();

        return $mapPool;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gameModeId = $this->argument('game_mode_id');
        $teamSize = $this->argument('team_size');

        $matchQueue = Redis::keys("match_queue:{$teamSize}v{$teamSize}:*");

        if (count($matchQueue) < 2) {
            return;
        }

        $matchups = [];
        foreach ($matchQueue as $index1 => $team1Key) {
            $team1 = Redis::hgetall($team1Key);

            for ($index2 = $index1 + 1; $index2 < count($matchQueue); $index2++) {
                $team2Key = $matchQueue[$index2];
                $team2 = Redis::hgetall($team2Key);

                $matchups[] = [
                    'team1' => $team1['team_id'],
                    'team2' => $team2['team_id'],
                    'rating_difference' => abs($team1['rating'] - $team2['rating']),
                ];
            }
        }        usort($matchups, function ($a, $b) {
            return $a['rating_difference'] <=> $b['rating_difference'];
        });

        $match = VashMatch::create([
            'map_pool_id' => 1,
        ]);

        $matchParticipants = $match->matchParticipants()->createMany([
            [
                'team_id' => $matchups[0]['team1'],
            ],
            [
                'team_id' => $matchups[0]['team2'],
            ],
        ]);

        foreach ($matchParticipants as $participant) {
            foreach ($participant->team->teamMembers as $member) {
                $participant->matchParticipantPlayers()->create([
                    'team_member_id' => $member->id,
                ]);
            }
        }

        foreach ($matchParticipants as $i => $matchParticipant) {
            $matchParticipant->matchParticipantPlayers;

            Redis::del("match_queue:{$teamSize}v{$teamSize}:{$matchParticipant->team->id}");
        }
    }
}
