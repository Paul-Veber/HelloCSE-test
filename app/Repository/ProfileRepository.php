<?php

namespace App\Repository;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;

class profileRepository
{
    static public function create(array $data): bool
    {
        $profile = new Profile();

        $profile->firstname = $data['first_name'];
        $profile->lastname = $data['last_name'];
        //$profile->image = $data['image'];
        $profile->status = $data['status'];

        return $profile->save();
    }

    static public function update(array $data, int $id): bool
    {
        $profile = Profile::find($id);

        $profile->firstname = $data['first_name'] ?? $profile->firstname;
        $profile->lastname = $data['last_name'] ?? $profile->lastname;
        //$profile->image = $data['image'] ?? $profile->image;
        $profile->status = $data['status'] ?? $profile->status;

        return $profile->update();
    }

    static public function delete(profile $profile): bool | null
    {
        return $profile->delete();
    }

    //For public use : get all active profiles and don't return satus field
    static public function publicAll(): Collection
    {
        return profile::all()
            ->where('status', 'active')
            ->select("id", "firstname", "lastname", "image");
    }

    //For admin use
    static public function adminAll(): Collection
    {
        return profile::all();
    }
}
