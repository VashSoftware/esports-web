<?php

use App\Http\Controllers\GameModeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MapPoolController;
use App\Http\Controllers\MapPoolMapController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\OrganizationController;
use App\Models\Mod;
use App\Models\VashMatch;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Home', [
        'matches' => VashMatch::all()
    ]);
});

Route::get('admin', function () {
    return Inertia::render('Admin', [
        'mods' => Mod::all()
    ]);
});

Route::resource('matches', MatchController::class);
Route::get('/matches/{match}/play', [MatchController::class, 'play'])->name('matches.play');

Route::resource('map_pools', MapPoolController::class);

Route::resource('map_pool_maps', MapPoolMapController::class);

Route::resource('mods', ModController::class);

Route::resource('events', EventController::class);
Route::get('/events/{event}/manage', [EventController::class, 'manage'])->name('events.manage');

Route::resource('rounds', RoundController::class);

Route::resource('teams', TeamController::class);

Route::resource('users', ProfileController::class);

Route::resource('organizations', OrganizationController::class);

Route::resource('games', GameController::class);

Route::resource('game_modes', GameModeController::class);

Route::get('/maps/search', [MapController::class, 'search'])->name('maps.search');
Route::resource('maps', MapController::class);

Route::inertia('terms', 'Terms');
Route::inertia('privacy', 'Privacy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
