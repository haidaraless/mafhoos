<?php

use App\Enums\FeeStatus;
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
        Schema::create('fees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('appointment_id')->constrained('appointments');
            $table->decimal('amount', 10, 2);
            $table->string('description');
            $table->enum('status', FeeStatus::cases())->default(FeeStatus::UNPAID->value);
            $table->string('payment_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
