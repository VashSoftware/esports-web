<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
        ]);

        Vite::prefetch(concurrency: 3);
    }
}
