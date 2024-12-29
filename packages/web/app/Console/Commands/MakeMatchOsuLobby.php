<?php

namespace App\Console\Commands;

use App\Services\OsuService;
use Illuminate\Console\Command;

class CheckOsuLobbies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:make-osu-lobby {match-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes an osu! lobby for a match.';

    /**
     * Execute the console command.
     */
    public function handle(OsuService $osuService)
    {
        $osuService->makeOsuLobby($this->argument('match-id'));
    }
}
