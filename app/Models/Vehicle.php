<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasUlids;

    protected $guarded = [];

    public function spareparts(): HasMany
    {
        return $this->hasMany(VehicleSparepart::class);
    }

}
