<?php

use App\Models\Appointment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('number', 20)->nullable()->unique()->after('id');
        });

        DB::transaction(function () {
            $counter = 1;

            Appointment::orderBy('created_at')
                ->orderBy('id')
                ->chunk(200, function ($appointments) use (&$counter) {
                    foreach ($appointments as $appointment) {
                        $appointment->forceFill([
                            'number' => str_pad((string) $counter, 6, '0', STR_PAD_LEFT),
                        ])->saveQuietly();

                        $counter++;
                    }
                });
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
};

