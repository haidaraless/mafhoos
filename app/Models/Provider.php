<?php

namespace App\Models;

use App\Enums\ProviderType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => ProviderType::class,
    ];

    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function availableTimes(): HasMany
    {
        return $this->hasMany(AvailableTime::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function quotationProviders(): HasMany
    {
        return $this->hasMany(QuotationProvider::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
