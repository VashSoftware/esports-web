<?php

namespace App\Console\Commands;

use App\Events\MatchEnded;
use App\Models\VashMatch;
use App\Services\OsuService;
use Illuminate\Console\Command;

class EndMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:end {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ends a match.';

    /**
     * Execute the console command.
     */
    public function handle(OsuService $osuService)
    {
        $matchId = $this->argument('id');

        VashMatch::find($matchId)->update([
            'finished_at' => now(),
        ]);

        $osuService->closeLobby($matchId);

        event(new MatchEnded($matchId));
    }
}
