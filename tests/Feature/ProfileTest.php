<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_profile(): void
    {
        // check if guest can't create profile
        $response = $this->post(route('api.profile.store'), [
            'first_name' => 'test',
            'last_name' => 'user',
            'status' => 'active',
        ]);
        $response->assertStatus(302);

        $user = Administrator::factory()->create();
        $file = UploadedFile::fake()->image("default.jpg")->size(1024);
        $response = $this
            ->actingAs($user)
            ->post(route('api.profile.store'), [
                'first_name' => 'test',
                'last_name' => 'user',
                'status' => 'active',
                'image' => $file,
            ]);
        $response->assertRedirect(route('dashboard'));
        Storage::disk('local')->assertExists('profile/' . $file->hashName());
        $this->assertDatabaseHas('profiles', ['firstname' => 'test', 'lastname' => 'user', 'status' => 'active']);
    }

    public function test_update_profile(): void
    {

        // check if guest can't update profile
        $response = $this->patch(route('api.profile.update'), [
            'id' => 1,
            'first_name' => 'Test Updated',
        ]);
        $response->assertStatus(302);

        $user = Administrator::factory()->create();
        $profile = Profile::factory()->create();
        $file = UploadedFile::fake()->image("default.jpg")->size(1024);
        $response = $this
            ->actingAs($user)
            ->patch(route('api.profile.update'), [
                'id' => $profile->id,
                'first_name' => 'Test Updated',
                'image' => $file,
            ]);
        $response->assertRedirect(route('dashboard'));
        Storage::disk('local')->assertExists('profile/' . $file->hashName());
        $this->assertDatabaseHas('profiles', ['firstname' => 'Test Updated', 'id' => $profile->id, 'image' => 'profile/' . $file->hashName()]);
    }

    public function test_delete_profile(): void
    {
        // check if guest can't delete profile
        $response = $this->delete(route('api.profile.delete', ['profile' => 1]));
        $response->assertStatus(302);

        $user = Administrator::factory()->create();
        $profile = Profile::factory()->create();
        $response = $this
            ->actingAs($user)
            ->delete(route('api.profile.delete', ['profile' => $profile->id]));
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
    }

    public function test_get_all_profiles(): void
    {
        // check if guest can see all active profiles and don't return status field
        Profile::factory()->count(5)->create();
        $response = $this->get(route('api.profile.all'));

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->has('data', 5)
                    ->has(
                        'data.0',
                        fn ($json) =>
                        $json
                            ->missing('status')
                            ->etc()
                    )
                    ->etc()
            );

        // check if guest can't see inactive profiles
        profile::factory()->inactive()->count(5)->create();
        $response = $this->get(route('api.profile.all'));
        $response->assertJsonCount(5, 'data');

        // check if guest can't see waiting profiles
        profile::factory()->waiting()->count(5)->create();
        $response = $this->get(route('api.profile.all'));
        $response->assertJsonCount(5, 'data');

        // check if admin can see all profiles
        $user = Administrator::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('api.profile.all'));
        $response->assertJsonCount(15, 'data');
    }
}
