<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'user' => (function (Request $request) {
                return $request->user() ? $request->user()->only('id', 'name', 'email', 'profile') : null;
            }),
            'match_queue' => (function (Request $request) {
                if ($user = $request->user()) {
                    $personalTeam = $user->profile->personalTeam();

                    if ($personalTeam) {
                        return Redis::sismember('match_queue', $personalTeam->id);
                    }
                }

                return null;
            }),
        ]);

        Vite::prefetch(concurrency: 3);
    }
}
