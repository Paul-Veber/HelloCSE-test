<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Profile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Administrator::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Profile::factory()
            ->count(20)
            ->create();

        Profile::factory()
            ->inactive()
            ->count(5)
            ->create();

        Profile::factory()
            ->waiting()
            ->count(5)
            ->create();
    }
}
