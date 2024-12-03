<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventGroupController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameModeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MapPoolController;
use App\Http\Controllers\MapPoolMapController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MatchQueueController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\TeamController;
use App\Models\Mod;
use App\Models\Score;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\VashMatch;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/picture', [ProfileController::class, 'picture'])->name('profile.picture');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return Inertia::render('Home', [
            'matches' => VashMatch::with('matchParticipants.team')->get(),
        ]);
    });

    Route::get('admin', function () {
        return Inertia::render('Admin', [
            'mods' => Mod::all(),
        ]);
    });

    Route::resource('/matches', MatchController::class);
    Route::post('/match-queue', [MatchQueueController::class, 'join'])->name('match-queue.join');
    Route::delete('/match-queue', [MatchQueueController::class, 'leave'])->name('match-queue.leave');
    Route::get('/matches/{match}/play', [MatchController::class, 'play'])->name('matches.play');

    Route::resource('map_pools', MapPoolController::class);

    Route::resource('map_pool_maps', MapPoolMapController::class);

    Route::resource('mods', ModController::class);

    Route::resource('events', EventController::class);
    Route::get('/events/{event}/manage', [EventController::class, 'manage'])->name('events.manage');
    Route::get('/events/{event}/register', [EventController::class, 'register'])->name('events.register');

    Route::resource('participants', ParticipantController::class);

    Route::resource('event_groups', EventGroupController::class);

    Route::resource('rounds', RoundController::class);

    Route::resource('teams', TeamController::class);

    Route::resource('users', ProfileController::class);

    Route::resource('organisations', OrganisationController::class);

    Route::resource('games', GameController::class);

    Route::resource('game_modes', GameModeController::class);

    Route::get('/maps/search', [MapController::class, 'search'])->name('maps.search');
    Route::resource('maps', MapController::class);

    Route::inertia('terms', 'Terms');
    Route::inertia('privacy', 'Privacy');

    Route::get('leaderboard', function () {
        return Inertia::render('Leaderboard', ['top_teams' => Team::all(), 'top_players' => TeamMember::with('profile')->get(), 'top_scores' => Score::all()]);

    });

    Route::get('settings', function () {
        return Inertia::render('Settings');
    });

    Route::get('premium', function () {
        return Inertia::render('Premium');
    });
});

require __DIR__.'/auth.php';
