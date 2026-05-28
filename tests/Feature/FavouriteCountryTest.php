<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavouriteCountryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_save_a_favourite_country(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('favourites.store'), [
            'country_code' => 'LKA',
            'name' => 'Sri Lanka',
            'capital' => 'Sri Jayawardenepura Kotte',
            'flag_url' => 'https://flagcdn.com/lk.svg',
            'personal_note' => 'I love my country!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('favourite_countries', [
            'user_id' => $user->id,
            'country_code' => 'LKA',
            'name' => 'Sri Lanka',
        ]);
    }
}
