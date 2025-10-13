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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('vin', 17)->unique()->after('id');
            $table->string('year')->nullable()->after('model');
            $table->string('make')->nullable()->after('year');
            $table->string('body_class')->nullable()->after('make');
            $table->string('engine_model')->nullable()->after('body_class');
            $table->string('fuel_type')->nullable()->after('engine_model');
            $table->string('drive_type')->nullable()->after('fuel_type');
            $table->string('transmission_style')->nullable()->after('drive_type');
            $table->string('vehicle_type')->nullable()->after('transmission_style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'vin',
                'year',
                'make',
                'body_class',
                'engine_model',
                'fuel_type',
                'drive_type',
                'transmission_style',
                'vehicle_type'
            ]);
        });
    }
};
