<?php

namespace Tests\Feature;

use App\Models\ParkingLot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotMapTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_view_parking_lot_spot_map(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $lot = ParkingLot::create([
            'name' => 'Test Lot',
            'location' => 'Test Location',
            'total_spots' => 10,
            'hourly_rate' => 0,
            'status' => 'open',
        ]);

        $response = $this->actingAs($user)
            ->get(route('client.lots.map', $lot));

        $response->assertOk()
            ->assertViewIs('client.lots.map')
            ->assertSee($lot->name)
            ->assertSee('Spot Map');
    }

    public function test_guests_are_redirected_from_lot_map(): void
    {
        $lot = ParkingLot::create([
            'name' => 'Test Lot',
            'location' => 'Test Location',
            'total_spots' => 10,
            'hourly_rate' => 0,
            'status' => 'open',
        ]);

        $response = $this->get(route('client.lots.map', $lot));

        $response->assertRedirect(route('login'));
    }
}
