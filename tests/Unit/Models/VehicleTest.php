<?php

use App\Models\Vehicle;
use App\Models\User;

test('vehicle belongs to user', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
    
    expect($vehicle->user)->toBeInstanceOf(User::class)
        ->and($vehicle->user->id)->toBe($user->id);
});
