<?php

use App\Enums\AccountStatus;

test('account status enum has all expected cases', function () {
    expect(AccountStatus::cases())->toHaveCount(6);
});

test('account status enum values are correct', function () {
    expect(AccountStatus::ACTIVE->value)->toBe('active')
        ->and(AccountStatus::INACTIVE->value)->toBe('inactive')
        ->and(AccountStatus::PENDING->value)->toBe('pending')
        ->and(AccountStatus::REJECTED->value)->toBe('rejected')
        ->and(AccountStatus::SUSPENDED->value)->toBe('suspended')
        ->and(AccountStatus::DELETED->value)->toBe('deleted');
});
