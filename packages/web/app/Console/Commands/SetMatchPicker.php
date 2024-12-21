<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class SetMatchPicker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:set-picker {match-id} {match-participant-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the current picker for a match.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        VashMatch::find($this->argument('match-id'))->update([
            'current_picker' => $this->argument('match-participant-id')
        ]);
    }
}
