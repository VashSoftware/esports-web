<?php

namespace App\Console\Commands;

use App\Services\MatchService;
use Illuminate\Console\Command;

class ResetMatchOsuLobby extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:reset-osu-lobby {match-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the osu! lobby for a match';

    /**
     * Execute the console command.
     */
    public function handle(MatchService $matchService)
    {
        $matchService->resetOsuLobby($this->argument('match-id'));
    }
}
