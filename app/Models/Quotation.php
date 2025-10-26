<?php

namespace App\Models;

use App\Enums\QuotationType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'type' => QuotationType::class,
        'total' => 'decimal:2',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function quotationRequest(): BelongsTo
    {
        return $this->belongsTo(QuotationRequest::class);
    }

    public function quotationSpareparts(): HasMany
    {
        return $this->hasMany(QuotationSparepart::class);
    }
}
