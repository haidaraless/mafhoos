<?php

use App\Models\Quotation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('number', 20)->nullable()->after('id');
        });

        // Populate existing records with appointment number
        DB::transaction(function () {
            Quotation::with('quotationRequest.inspection.appointment')
                ->chunk(200, function ($quotations) {
                    foreach ($quotations as $quotation) {
                        if ($quotation->quotationRequest && 
                            $quotation->quotationRequest->inspection && 
                            $quotation->quotationRequest->inspection->appointment && 
                            $quotation->quotationRequest->inspection->appointment->number) {
                            $quotation->forceFill([
                                'number' => $quotation->quotationRequest->inspection->appointment->number,
                            ])->saveQuietly();
                        }
                    }
                });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
};
