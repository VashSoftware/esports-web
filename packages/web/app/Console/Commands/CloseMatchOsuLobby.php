<?php

namespace App\Console\Commands;

use App\Services\OsuService;
use Illuminate\Console\Command;

class CloseMatchOsuLobby extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:close-lobby {match-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(OsuService $osuService)
    {
        $osuService->closeLobby($this->argument('match-id'));
    }
}
