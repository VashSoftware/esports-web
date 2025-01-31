<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;

class BanProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:ban {profile-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bans a user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $profileId = $this->argument('profile-id');

        $profile = Profile::find($profileId);

        $profile->banned_at = now();

        $profile->save();
    }
}
