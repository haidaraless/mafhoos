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
        Schema::create('quotation_providers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('quotation_request_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('provider_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_providers');
    }
};
