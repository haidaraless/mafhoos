<?php

use App\Enums\ProviderType;
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
        Schema::create('providers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('account_id')->constrained('accounts');
            $table->foreignUlid('city_id')->constrained('cities');
            $table->string('name');
            $table->string('commercial_record');
            $table->string('mobile');
            $table->string('email');
            $table->string('location')->nullable();
            $table->enum('type', ProviderType::cases())->default(ProviderType::VEHICLE_INSPECTION_CENTER->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
