<?php

namespace App\Console\Commands;

use App\Services\OsuService;
use Illuminate\Console\Command;

class InviteOsuPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:invite-player {player-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invites a player to an osu! lobby.';

    /**
     * Execute the console command.
     */
    public function handle(OsuService $osuService)
    {
        $osuService->inviteMatchPlayer($this->argument('player-id'));
    }
}
