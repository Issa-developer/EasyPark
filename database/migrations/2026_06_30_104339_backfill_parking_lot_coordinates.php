<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $coordinates = [
            'Students Parking Lot' => [
                'latitude' => -1.3103596848491732,
                'longitude' => 36.81509973688174,
            ],
            'Phase 1 Parking Lot' => [
                'latitude' => -1.3089167264291564,
                'longitude' => 36.81205148202973,
            ],
            'SBS Parking Lot' => [
                'latitude' => -1.3101040087838387,
                'longitude' => 36.81256198562499,
            ],
        ];

        foreach ($coordinates as $name => $coords) {
            DB::table('parking_lots')
                ->where('name', $name)
                ->update($coords);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('parking_lots')
            ->whereIn('name', [
                'Students Parking Lot',
                'Phase 1 Parking Lot',
                'SBS Parking Lot',
            ])
            ->update([
                'latitude' => null,
                'longitude' => null,
            ]);
    }
};
