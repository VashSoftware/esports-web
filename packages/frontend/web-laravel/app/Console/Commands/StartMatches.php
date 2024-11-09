<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VashMatch;

class StartMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts all matches that are ready to be played';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matches = VashMatch::where('status', 'ready')->get();
    }
}
