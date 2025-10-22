<?php

namespace App\Models;

use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Account extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => AccountType::class,
    ];

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
}
