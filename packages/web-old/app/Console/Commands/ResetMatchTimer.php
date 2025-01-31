<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class ResetMatchTimer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:reset-timer {match-id} {seconds=60}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the timestamp for the match timer. Default is set for 60 seconds, but a seconds value can be given to control this.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seconds = $this->argument('seconds');

        VashMatch::find($this->argument('match-id'))->update([
            'action_limit' => now()->modify('+'.$seconds.' seconds'),
        ]);
    }
}
