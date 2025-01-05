<?php

namespace App\Console\Commands;

use App\Models\MatchParticipantPlayer;
use App\Services\MatchService;
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
    public function handle(MatchService $matchService)
    {
        $matchService->inviteMatchPlayer(MatchParticipantPlayer::find($this->argument('player-id')));
    }
}
