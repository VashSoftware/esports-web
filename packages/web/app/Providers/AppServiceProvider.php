<?php

namespace App\Providers;

use App\Models\VashMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;


class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
    ];

    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'user' => (function (Request $request) {
                return $request->user()
                    ? $request->user()->load('profile.teamMembers.team')->only('id', 'name', 'email', 'profile')
                    : null;
            }),
            'match_queue' => (function (Request $request) {
                if ($user = $request->user()) {
                    $personalTeam = $user->profile->personalTeam();

                    if ($personalTeam) {
                        return Redis::exists('match_queue:1v1:'.$personalTeam->id);
                    }
                }

                return null;
            }),
            'current_matches' => (function (Request $request) {
                if (! $request->user()) {
                    return null;
                }

                $activeMatches = VashMatch::with('matchParticipants.matchParticipantPlayers.teamMember')
                    ->whereNull('finished_at')
                    ->get();

                $userProfileId = $request->user()->profile->id;

                $userActiveMatches = $activeMatches->filter(function ($match) use ($userProfileId) {
                    foreach ($match->matchParticipants as $participant) {
                        foreach ($participant->matchParticipantPlayers as $player) {
                            Log::debug($player);
                            if ($player->teamMember->profile_id == $userProfileId) {
                                return true;
                            }
                        }
                    }

                    return false;
                });

                return $userActiveMatches->all();
            }),
        ]);

        Vite::prefetch(concurrency: 3);
    }
}
