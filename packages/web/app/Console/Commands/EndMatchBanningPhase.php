<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class EndMatchBanningPhase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:end-ban {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ends the banning phase of a match.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matchId = $this->argument('id');

        VashMatch::find($matchId)->update([
            'current_banner' => null,
        ]);
    }
}
