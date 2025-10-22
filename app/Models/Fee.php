<?php

namespace App\Models;

use App\Enums\FeeStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'status' => FeeStatus::class,
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
