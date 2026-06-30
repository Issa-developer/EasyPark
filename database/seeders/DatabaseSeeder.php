<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ParkingLot;
use App\Models\ParkingSpot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@easypark.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        // Security Guard
        User::create([
            'name'     => 'Guard One',
            'email'    => 'guard@easypark.com',
            'password' => Hash::make('password'),
            'role'     => 'security',
            'status'   => 'active',
        ]);

        // Student/Lecturer
        User::create([
            'name'     => 'Test Student',
            'email'    => 'student@easypark.com',
            'password' => Hash::make('password'),
            'role'     => 'client',
            'status'   => 'active',
        ]);

        // 3 Strathmore Parking Lots with real coordinates
        $lots = [
            [
                'name' => 'Students Parking Lot', 
                'location' => 'Main Gate', 
                'latitude' => -1.3103596848491732,
                'longitude' => 36.81509973688174,
                'total_spots' => 50, 
                'hourly_rate' => 0, 
                'status' => 'open'
            ],
            [
                'name' => 'Phase 1 Parking Lot',  
                'location' => 'Phase 1',   
                'latitude' => -1.3089167264291564,
                'longitude' => 36.81205148202973,
                'total_spots' => 40, 
                'hourly_rate' => 0, 
                'status' => 'open'
            ],
            [
                'name' => 'SBS Parking Lot',       
                'location' => 'SBS Block', 
                'latitude' => -1.3101040087838387,
                'longitude' => 36.81256198562499,
                'total_spots' => 30, 
                'hourly_rate' => 0, 
                'status' => 'open'
            ],
        ];

        foreach ($lots as $lot) {
            $parkingLot = ParkingLot::create($lot);

            for ($i = 1; $i <= $lot['total_spots']; $i++) {
                ParkingSpot::create([
                    'parking_lot_id' => $parkingLot->id,
                    'spot_number'    => $i,
                    'status'         => 'available',
                ]);
            }
        }
    }
}