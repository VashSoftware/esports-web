<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function picture(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => ['nullable', File::image()],
        ]);

        if ($request->file('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $request->user()->profile()->update([
                'profile_picture' => $path,
            ]);
        }

        $request->user()->save();

        return back(status: 303);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => ['nullable', File::image()],
        ]);

        Log::debug($request);

        if ($request->file('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures');
            $request->user()->profile()->update([
                'profile_picture' => $path,
            ]);
        }

        $request->user()->save();

        return back(status: 303);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(string $id)
    {
        return Inertia::render('Profile', ['profile' => Profile::with('teamMembers.team')->with('organisationMembers.organisation')->find($id)]);
    }
}
