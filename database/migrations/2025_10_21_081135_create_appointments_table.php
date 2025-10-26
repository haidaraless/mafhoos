<?php

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('status', AppointmentStatus::cases())->default(AppointmentStatus::PENDING->value);
            $table->foreignUlid('vehicle_id')->constrained('vehicles');
            $table->foreignUlid('provider_id')->nullable()->constrained('providers');
            $table->enum('inspection_type', InspectionType::cases())->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
        Schema::dropIfExists('appointments');

    }
};
