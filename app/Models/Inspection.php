<?php

namespace App\Models;

use App\Enums\InspectionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'type' => InspectionType::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function damageSpareparts(): HasMany
    {
        return $this->hasMany(DamageSparepart::class);
    }
}
