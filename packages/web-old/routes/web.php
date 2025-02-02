<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/picture', [ProfileController::class, 'picture'])->name('profile.picture');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return Inertia::render('Home', [
            'matches' => VashMatch::with('matchParticipants.team')->whereNull('finished_at')->get(),
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
    Route::post('/matches/{match}/play/invite-player', [MatchController::class, 'invitePlayer'])->name('matches.invite-player');

    Route::resource('/match_bans', MatchBanController::class);
    Route::resource('/match_maps', MatchMapController::class);

    Route::resource('map_pools', MapPoolController::class);

    Route::resource('map_pool_maps', MapPoolMapController::class);

    Route::resource('map_pool_map_mods', MapPoolMapModController::class);

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

    Route::resource('rolls', RollController::class);
});
