<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this
            ->actingAs($user)
            ->post(route('api.profile.store'), [
                'first_name' => 'test',
                'last_name' => 'user',
                'status' => 'active',
                'image' => UploadedFile::fake()->image("default.jpg")->size(1024),
            ]);
        $response->assertRedirect(route('dashboard'));
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
        $response = $this
            ->actingAs($user)
            ->patch(route('api.profile.update'), [
                'id' => $profile->id,
                'first_name' => 'Test Updated',
                'image' => UploadedFile::fake()->image("updated.jpg")->size(1024),
            ]);
        $response->assertRedirect(route('dashboard'));
        assert($profile->first_name === 'Test Updated');
        assert($profile->image === 'profile/updated.jpg');
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
        assert(Profile::find($profile->id) === null);
    }

    public function test_get_all_profiles(): void
    {
        // check if guest can see all active profiles
        Profile::factory()->count(5)->create();
        $response = $this->get(route('api.profile.all'));
        $response->assertJsonCount(5, 'data');

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
