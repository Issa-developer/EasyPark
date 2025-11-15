<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // relationship to user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // optional: link to parking session
            $table->foreignId('session_id')->nullable()->constrained('parking_sessions')->onDelete('set null');

            // payment data
            $table->decimal('amount', 10, 2);
            $table->string('method')->default('mpesa'); // mpesa, credit_card, cash, etc
            $table->string('reference')->unique(); // transaction reference code
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
