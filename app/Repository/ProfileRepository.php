<?php

namespace App\Repository;

use App\Models\Profile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProfileRepository
{
    static public function create(array $data): bool
    {
        $profile = new Profile();

        $profile->firstname = $data['first_name'];
        $profile->lastname = $data['last_name'];
        $profile->image = $data['image'];
        $profile->status = $data['status'];

        return $profile->save();
    }

    static public function update(array $data, int $id): bool
    {
        $profile = Profile::find($id);

        // we don't want to delete default image
        if (isset($data['image'])) {
            if ($profile['image'] !== 'profile/default.jpg') {
                Storage::delete($profile->image);
            }
        }

        $profile->firstname = $data['first_name'] ?? $profile->firstname;
        $profile->lastname = $data['last_name'] ?? $profile->lastname;
        $profile->image = $data['image'] ?? $profile->image;
        $profile->status = $data['status'] ?? $profile->status;

        return $profile->update();
    }

    static public function delete(profile $profile): bool | null
    {
        // we don't want to delete default image
        if ($profile->image !== 'profile/default.jpg') {
            storage::delete($profile->image);
        }
        return $profile->delete();
    }

    //For public use : get all active profiles and don't return satus field
    static public function publicAll(int $perPage = 15): LengthAwarePaginator
    {
        return profile::where('status', 'active')
            ->select("id", "firstname", "lastname", "image", "created_at", "updated_at")
            ->paginate($perPage);
    }

    //For admin use
    static public function adminAll(int $perPage = 15): LengthAwarePaginator
    {
        return profile::paginate($perPage);
    }
}
