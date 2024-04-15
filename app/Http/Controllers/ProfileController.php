<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileCreateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use App\Repository\ProfileRepository;

class ProfileController extends Controller
{

    public function GetAllProfiles()
    {
        $auth = auth()->check();

        if ($auth) {
            return ProfileRepository::adminAll();
        } else {
            return ProfileRepository::publicAll();
        }
    }

    public function store(ProfileCreateRequest $request): RedirectResponse
    {
        $newProfileValue = $request->validated();

        $created = ProfileRepository::create($newProfileValue);

        if ($created) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Profile created successfully');
        } else {
            return redirect()
                ->route('profile.create')
                ->with('error', 'Profile creation failed');
        }
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $profileValue = $request->validated();

        $updated = ProfileRepository::update($profileValue, $request->id);

        if ($updated) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Profile updated successfully');
        } else {
            return redirect()
                ->route('api.profile.update')
                ->with('error', 'Profile update failed');
        }
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        $deleted = ProfileRepository::delete($profile);

        if ($deleted) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Profile deleted successfully');
        } else {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'Profile deletion failed');
        }
    }
}
