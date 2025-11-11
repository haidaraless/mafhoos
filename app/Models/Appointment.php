<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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
        'auto_quotation_request' => 'boolean',
    ];

    public function scopeConfirmed($query)
    {
        return $query->where('status', AppointmentStatus::CONFIRMED->value);
    }

    public function scopePending($query)
    {
        return $query->where('status', AppointmentStatus::PENDING->value);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', AppointmentStatus::CANCELLED->value);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', AppointmentStatus::COMPLETED->value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

    public function getInspectionType(): string
    {
        return ucfirst(str_replace('-', ' ', $this->inspection_type->value))    ;
    }

    public static function createDraftAppointment(): Appointment
    {
        if (! Auth::user()->currentAccount->isUser()) {
            abort(403, 'You are not authorized');
        }

        $appointment = self::where('user_id', Auth::user()->id)->where('status', AppointmentStatus::PENDING->value)->first();

        if ($appointment) {
            return $appointment;
        }

        return self::create([
            'user_id' => Auth::user()->id,
            'status' => AppointmentStatus::PENDING->value,
        ]);
    }

    public static function createAppointmentViaVehicle(Vehicle $vehicle): Appointment
    {
        if (! Auth::user()->currentAccount->isUser()) {
            abort(403, 'You are not authorized');
        }

        return self::create([
            'user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle->id,
            'status' => AppointmentStatus::PENDING->value,
        ]);
    }
}
