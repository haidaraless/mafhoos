<?php

namespace App\Models;

use App\Enums\Priority;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamageSparepart extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'priority' => Priority::class,
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class);
    }
}
