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
        Schema::table('spareparts', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('year_range')->nullable();
            $table->string('category')->nullable();
            $table->string('price_range')->nullable();
            $table->string('availability')->default('In Stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spareparts', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'brand',
                'vehicle_make',
                'vehicle_model',
                'year_range',
                'category',
                'price_range',
                'availability'
            ]);
        });
    }
};
