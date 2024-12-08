<?php

namespace App\Console\Commands;

use App\Services\OsuService;
use Illuminate\Console\Command;

class SendOsuMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'osu:send-message {channel} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(OsuService $osuService)
    {
        $channel = $this->argument('channel');
        $message = $this->argument('message');

        $osuService->sendIRCMessage($channel, $message);
    }
}
