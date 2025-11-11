<?php

use App\Models\Account;
use App\Models\User;

test('account has polymorphic accountable relationship', function () {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'accountable_type' => User::class,
        'accountable_id' => $user->id,
    ]);
    
    expect($account->accountable)->toBeInstanceOf(User::class);
});

test('account can check if accountable is user', function () {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'accountable_type' => User::class,
        'accountable_id' => $user->id,
    ]);
    
    expect($account->isUser())->toBeTrue()
        ->and($account->isProvider())->toBeFalse();
});
