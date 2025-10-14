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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->string('vin', 17)->unique();
            $table->string('name');
            $table->string('model');
            $table->string('year')->nullable();
            $table->string('make')->nullable();
            $table->string('body_class')->nullable();
            $table->string('engine_model')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('drive_type')->nullable();
            $table->string('transmission_style')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
