<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class ListMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all ongoing matches.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matches = VashMatch::whereNull('finished_at')->get(['id', 'map_pool_id', 'osu_lobby', 'created_at'])->toArray();

        $this->table(['ID', 'Map Pool ID', 'osu! lobby ID', 'Created At'], $matches);
    }
}
