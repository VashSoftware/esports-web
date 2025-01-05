<?php

namespace App\Console\Commands;

use App\Services\MatchService;
use Illuminate\Console\Command;

class MakeMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:make {map_pool_id} {bans_per_team} {teams*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a match between teams.';

    /**
     * Execute the console command.
     */
    public function handle(MatchService $matchService)
    {
        $mapPoolId = $this->argument('map_pool_id');
        $bansPerTeam = $this->argument('bans_per_team');
        $teams = $this->argument('teams');

        $matchService->createMatch($mapPoolId, $teams, $bansPerTeam);
    }
}
