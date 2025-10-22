<?php

namespace Tests\Feature;

use App\Enums\InspectionType;
use App\Livewire\Appointments\PayFees;
use App\Models\Appointment;
use App\Models\Provider;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PayFeesTest extends TestCase
{
    use RefreshDatabase;

    public function test_pay_fees_component_loads_correctly()
    {
        $user = User::factory()->create();
        
        // Create a mock appointment object
        $appointment = new Appointment([
            'vehicle_id' => '01test-vehicle-id',
            'provider_id' => '01test-provider-id',
            'inspection_type' => InspectionType::UNDERCARRIAGE_INSPECTION->value,
            'scheduled_at' => now()->addDays(1),
        ]);
        $appointment->id = '01test-appointment-id';
        $appointment->exists = true; // Mark as existing to avoid database operations

        $this->actingAs($user);

        Livewire::test(PayFees::class, ['appointment' => $appointment])
            ->assertSee('Payment Details')
            ->assertSee('SAR 150.00')
            ->assertSee('undercarriage inspection');
    }

    public function test_inspection_prices_are_correct()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);

        // Test undercarriage inspection price
        $appointment1 = new Appointment([
            'vehicle_id' => '01test-vehicle-id',
            'provider_id' => '01test-provider-id',
            'inspection_type' => InspectionType::UNDERCARRIAGE_INSPECTION->value,
            'scheduled_at' => now()->addDays(1),
        ]);
        $appointment1->id = '01test-appointment-id-1';
        $appointment1->exists = true;

        Livewire::test(PayFees::class, ['appointment' => $appointment1])
            ->assertSee('SAR 150.00');

        // Test engine inspection price
        $appointment2 = new Appointment([
            'vehicle_id' => '01test-vehicle-id',
            'provider_id' => '01test-provider-id',
            'inspection_type' => InspectionType::ENGINE_INSPECTION->value,
            'scheduled_at' => now()->addDays(1),
        ]);
        $appointment2->id = '01test-appointment-id-2';
        $appointment2->exists = true;

        Livewire::test(PayFees::class, ['appointment' => $appointment2])
            ->assertSee('SAR 200.00');

        // Test comprehensive inspection price
        $appointment3 = new Appointment([
            'vehicle_id' => '01test-vehicle-id',
            'provider_id' => '01test-provider-id',
            'inspection_type' => InspectionType::COMPREHENSIVE_INSPECTION->value,
            'scheduled_at' => now()->addDays(1),
        ]);
        $appointment3->id = '01test-appointment-id-3';
        $appointment3->exists = true;

        Livewire::test(PayFees::class, ['appointment' => $appointment3])
            ->assertSee('SAR 300.00');
    }

    public function test_payment_form_validation()
    {
        $user = User::factory()->create();
        
        $appointment = new Appointment([
            'vehicle_id' => '01test-vehicle-id',
            'provider_id' => '01test-provider-id',
            'inspection_type' => InspectionType::UNDERCARRIAGE_INSPECTION->value,
            'scheduled_at' => now()->addDays(1),
        ]);
        $appointment->id = '01test-appointment-id';
        $appointment->exists = true;

        $this->actingAs($user);

        Livewire::test(PayFees::class, ['appointment' => $appointment])
            ->assertSee('Card Number')
            ->assertSee('Cardholder Name')
            ->assertSee('Expiry Date')
            ->assertSee('CVV');
    }
}
