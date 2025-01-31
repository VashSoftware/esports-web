<?php

namespace App\Jobs;

use App\Models\VashMatch;
use App\Services\OsuService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GetOsuSettings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * The ID of the match.
     */
    public int $matchId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $matchId)
    {
        $this->matchId = $matchId;
    }

    /**
     * Execute the job.
     */
    public function handle(OsuService $osuService): void
    {
        // Retrieve the match
        $match = VashMatch::find($this->matchId);

        // If the match doesn't exist, log and exit
        if (! $match) {
            Log::warning("GetOsuSettings Job: Match with ID {$this->matchId} not found.");

            return;
        }

        // If the match has finished, log and exit
        if ($match->finished_at) {
            Log::info("GetOsuSettings Job: Match ID {$this->matchId} has finished. Job will not re-dispatch.");

            return;
        }

        // Send the IRC message
        $channel = '#mp_'.$match->osu_lobby;
        $message = '!mp settings';
        $osuService->sendIRCMessage($channel, $message);
        Log::info("GetOsuSettings Job: Sent message '{$message}' to channel '{$channel}' for Match ID {$this->matchId}.");

        // Re-dispatch the job with a delay only if the match is still ongoing
        // Double-checking to avoid race conditions
        $match->refresh(); // Refresh the model to get the latest state from the database
        if (! $match->finished_at) {
            self::dispatch($this->matchId)->delay(now()->addSeconds(15));
            Log::info("GetOsuSettings Job: Re-dispatched for Match ID {$this->matchId} with a 15-second delay.");
        } else {
            Log::info("GetOsuSettings Job: Match ID {$this->matchId} has finished after refresh. Job will not re-dispatch.");
        }
    }
}
