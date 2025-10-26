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
        Schema::create('quotation_spareparts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('damage_sparepart_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_spareparts');
    }
};
