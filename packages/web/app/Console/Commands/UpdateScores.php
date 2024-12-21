<?php

namespace App\Console\Commands;

use App\Events\ScoreUpdated;
use App\Models\VashMatch;
use Illuminate\Console\Command;

class UpdateScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:update-scores {match-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matchId = $this->argument('match-id');
        $match = VashMatch::find($matchId);

        event(new ScoreUpdated($match));
    }
}
