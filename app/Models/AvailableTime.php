<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailableTime extends Model
{
    protected $guarded = [];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
