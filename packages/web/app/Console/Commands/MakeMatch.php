<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MatchService;

class MakeMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:make {map_pool_id} {teams*}';

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
        $teams = $this->argument('teams');

        $matchService->createMatch($mapPoolId, $teams);
    }
}
