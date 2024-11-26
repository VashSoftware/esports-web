<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
            'display_name' => 'required|string'
        ]);

        Log::debug($validated);

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

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
