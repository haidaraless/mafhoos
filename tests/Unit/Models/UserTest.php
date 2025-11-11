<?php

use App\Models\User;
use App\Models\Vehicle;

test('user can have multiple vehicles', function () {
    $user = User::factory()->create();
    
    expect($user->vehicles())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('user initials returns first letters', function () {
    $user = User::factory()->create(['name' => 'Ahmed Ali']);
    
    expect($user->initials())->toBe('AA');
});
