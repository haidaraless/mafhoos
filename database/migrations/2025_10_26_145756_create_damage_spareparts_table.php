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
        Schema::create('damage_spareparts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('inspection_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('sparepart_id')->constrained()->onDelete('cascade');
            $table->string('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_spareparts');
    }
};
