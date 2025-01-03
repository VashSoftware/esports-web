<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use App\Services\MatchService;
use Illuminate\Console\Command;

class SetMatchCurrentMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:set-current-map {match-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(MatchService $matchService)
    {
        $matchService->setCurrentMap(VashMatch::find($this->argument('match-id')));
    }
}
