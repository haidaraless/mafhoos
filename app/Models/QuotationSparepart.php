<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationSparepart extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function damageSparepart(): BelongsTo
    {
        return $this->belongsTo(DamageSparepart::class);
    }
}
