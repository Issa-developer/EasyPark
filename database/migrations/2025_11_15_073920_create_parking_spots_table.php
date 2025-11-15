<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parking_spots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained()->onDelete('cascade');
            $table->string('spot_number'); // e.g. A-01
            $table->string('level')->nullable(); // Level 1, Garage A
            $table->string('zone')->nullable();  // Visitor Parking
            $table->enum('type', ['standard', 'accessible', 'ev_charging', 'motorcycle', 'other'])
                  ->default('standard');
            $table->enum('status', ['available', 'occupied', 'reserved', 'out_of_service'])
                  ->default('available');
            $table->timestamps();

            $table->unique(['parking_lot_id', 'spot_number']); // no duplicates per lot
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_spots');
    }
};
