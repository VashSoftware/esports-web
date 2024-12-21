<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class EndMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:end {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ends a match.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        VashMatch::find($this->argument('id'))->update([
            'finished_at' => now(),
        ]);
    }
}
