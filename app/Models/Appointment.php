<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Enums\InspectionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use App\Enums\AccountType;

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

    public static function createDraftAppointment(string $vehicleId=null): Appointment
    {
        $user = User::find(Auth::user()->id);

        if (Auth::user()->currentAccount->type !== AccountType::VEHICLE_OWNER) {
            return abort(403, 'You are not authorized');
        }
        return self::create([
            'vehicle_id' => $vehicleId,
            'status' => AppointmentStatus::PENDING->value,
        ]);
    }
}
