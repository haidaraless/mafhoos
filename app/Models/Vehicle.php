<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'vin',
        'year',
        'make',
        'body_class',
        'engine_model',
        'fuel_type',
        'drive_type',
        'transmission_style',
        'vehicle_type',
    ];

    public function spareparts(): HasMany
    {
        return $this->hasMany(VehicleSparepart::class);
    }

}
