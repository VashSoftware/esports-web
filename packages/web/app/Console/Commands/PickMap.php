<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class PickMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:pick-map {match-id} {map-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Picks a map in a match. Aborts the current map if needed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matchId = $this->argument('match-id');
        $mapId = $this->argument('map-id');

        $match = VashMatch::find($matchId);

        $match->matchMaps()->create([
            'map_pool_map_id' => $mapId,
        ]);
    }
}
