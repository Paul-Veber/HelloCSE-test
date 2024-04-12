<?php

namespace App\Repository;

use App\Models\Profil;
use Illuminate\Database\Eloquent\Collection;

class ProfilRepository
{
    public function create(array $data): bool
    {
        $profil = new Profil();
        $profil->firstname = $data['first_name'];
        $profil->lastname = $data['last_name'];
        $profil->image = $data['image'];
        $profil->status = $data['status'];

        return $profil->save();
    }

    public function update(array $data, Profil $profil): bool
    {
        $profil->firstname = $data['first_name'] ?? $profil->firstname;
        $profil->lastname = $data['last_name'] ?? $profil->lastname;
        $profil->image = $data['image'] ?? $profil->image;
        $profil->status = $data['status'] ?? $profil->status;
        return $profil->update();
    }

    public function delete(Profil $profil): bool | null
    {
        return $profil->delete();
    }

    public function publicAll(): Collection
    {
        return Profil::all()->where('status', 'active')->select("id", "firstname", "lastname", "image");
    }

    public function adminAll(): Collection
    {
        return Profil::all();
    }
}
