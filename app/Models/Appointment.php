<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'inspection_type' => InspectionType::class,
        'status' => AppointmentStatus::class,
        'scheduled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }
}
