<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Account extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function isProvider(): bool
    {
        return $this->accountable_type === Provider::class;
    }

    public function isUser(): bool
    {
        return $this->accountable_type === User::class;
    }
}
