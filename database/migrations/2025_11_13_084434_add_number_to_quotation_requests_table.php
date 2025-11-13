<?php

use App\Models\QuotationRequest;
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
        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->string('number', 20)->nullable()->after('id');
        });

        // Populate existing records with appointment number
        DB::transaction(function () {
            QuotationRequest::with('inspection.appointment')
                ->chunk(200, function ($quotationRequests) {
                    foreach ($quotationRequests as $quotationRequest) {
                        if ($quotationRequest->inspection && $quotationRequest->inspection->appointment && $quotationRequest->inspection->appointment->number) {
                            $quotationRequest->forceFill([
                                'number' => $quotationRequest->inspection->appointment->number,
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
        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
};
