<?php

namespace App\Models;

use App\Enums\QuotationRequestStatus;
use App\Enums\QuotationType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuotationRequest extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'type' => QuotationType::class,
        'status' => QuotationRequestStatus::class,
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function providers(): HasMany
    {
        return $this->hasMany(QuotationProvider::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
