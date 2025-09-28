<?php

namespace App\Models;

use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'type' => AccountType::class,
    ];

    /*
     * types of accounts
     * 1. Vehicle Inspection Center
     * 2. Auto Repair Workshop
     * 3. Spare Parts Supplier
     * 4. Car Owner
     */


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
