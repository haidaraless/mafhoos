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
        Schema::create('vehicle_spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('vehicle_id')->constrained('vehicles');
            $table->foreignUlid('sparepart_id')->constrained('spareparts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_spareparts');
    }
};
