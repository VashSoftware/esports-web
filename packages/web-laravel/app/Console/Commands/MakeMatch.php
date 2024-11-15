<?php

namespace App\Console\Commands;

use App\Models\VashMatch;
use Illuminate\Console\Command;

class MakeMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:make {team*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a match between teams.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $teams = $this->arguments();

        VashMatch::create([
            'match_participants' => $teams
        ]);
    }
}
