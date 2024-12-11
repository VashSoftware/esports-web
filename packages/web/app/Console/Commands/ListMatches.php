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
        $matches = VashMatch::all(['id', 'map_pool_id', 'created_at'])->toArray();

        $this->table(['ID', 'Map Pool ID', 'Created At'], $matches);
    }
}
