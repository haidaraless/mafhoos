<?php

namespace App\Models;

use App\Enums\ProviderType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'type' => ProviderType::class,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function availableTimes(): HasMany
    {
        return $this->hasMany(AvailableTime::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
