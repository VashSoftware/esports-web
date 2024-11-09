<?php

use App\Http\Controllers\MapPoolController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\OrganizationController;
use App\Models\VashMatch;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'matches' => VashMatch::all()
    ]);
});

Route::resource('matches', MatchController::class);
Route::get('/matches/{match}/play', [MatchController::class, 'play'])->name('matches.play');

Route::resource('map_pools', MapPoolController::class);

Route::resource('events', EventController::class);
Route::get('/events/{event}/manage', [EventController::class, 'manage'])->name('events.manage');

Route::resource('teams', TeamController::class);

Route::resource('users', ProfileController::class);

Route::resource('organizations', OrganizationController::class);

Route::inertia('terms', 'Terms');
Route::inertia('privacy', 'Privacy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
