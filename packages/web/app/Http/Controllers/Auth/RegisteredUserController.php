<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'username' => 'required|string',
            'display_name' => 'required|string',
        ]);

        DB::beginTransaction();
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $existingProfile = Profile::firstWhere('username', $request->username);
        if ($existingProfile) {
            throw ValidationException;
        }

        $profile = $user->profile()->create([
            'username' => $validated['username'],
            'display_name' => $validated['display_name'],
        ]);

        $team = Team::create([
            'name' => $validated['display_name'],
            'is_personal_team' => true,
        ]);

        $teamMember = TeamMember::create([
            'team_id' => $team->id,
            'profile_id' => $profile->id,
        ]);

        $profile->personalTeam()->ratings()->createMany([[
            'game_id' => 1,
            'rating' => 1000,
        ]]);
        DB::commit();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
