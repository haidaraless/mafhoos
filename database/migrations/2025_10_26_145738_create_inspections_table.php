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
        Schema::create('inspections', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('number')->unique();
            $table->string('type');
            $table->text('report')->nullable();
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('provider_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('vehicle_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
