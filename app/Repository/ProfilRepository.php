<?php

namespace App\Repository;

use App\Models\Profil;
use Illuminate\Database\Eloquent\Collection;

class ProfilRepository
{
    public function create(array $data): bool
    {
        $profil = new Profil();
        $profil->name = $data['name'];
        $profil->email = $data['email'];
        return $profil->save();
    }

    public function update(array $data, Profil $profil): bool
    {
        $profil->name = $data['name'];
        $profil->email = $data['email'];
        return $profil->save();
    }

    public function delete(Profil $profil): bool | null
    {
        return $profil->delete();
    }

    public function all(): Collection
    {
        return Profil::all();
    }
}
