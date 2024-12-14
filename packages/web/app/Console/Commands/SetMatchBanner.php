<?php

namespace App\Console\Commands;

use App\Models\MatchParticipant;
use App\Models\VashMatch;
use Illuminate\Console\Command;

class SetMatchBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:set-banner {match-participant-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets a match participant ID as the current banner.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matchParticipantId = $this->argument('match-participant-id');

        $matchParticipant = MatchParticipant::find($matchParticipantId);

        $matchParticipant->vashMatch()->update([
            'current_banner' => $matchParticipantId
        ]);
    }
}
