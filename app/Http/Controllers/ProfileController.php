<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileCreateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use App\Repository\ProfileRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function GetAllProfiles(): LengthAwarePaginator
    {
        $auth = auth()->check();

        if ($auth) {
            $paginatedValues = ProfileRepository::adminAll();
            // Replace the images' path with the url to display them
            foreach ($paginatedValues as $value) {
                $value['image'] = Storage::url($value['image']);
            }
            return $paginatedValues;
        } else {
            $paginatedValues = ProfileRepository::publicAll();
            // Replace the images' path with the url to display them
            foreach ($paginatedValues as $value) {
                $value['image'] = Storage::url($value['image']);
            }
            return $paginatedValues;
        }
    }

    public function store(ProfileCreateRequest $request): RedirectResponse
    {
        $newProfileValue = $request->validated();

        $image = $request->file('image');
        // Replace the image with the path and store it
        $newProfileValue['image'] = Storage::putFile('profile', $image);

        $created = ProfileRepository::create($newProfileValue);

        if ($created) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Profile created successfully');
        } else {
            return redirect()
                ->route('api.profile.create')
                ->with('error', 'Profile creation failed');
        }
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $profileValue = $request->validated();

        // check if the image is updated
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Replace the image with the path and store it
            $profileValue['image'] = Storage::putFile('profile', $image);
        }

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
