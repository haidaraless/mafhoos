<?php

namespace App\Livewire\Appointments;

use App\Enums\InspectionType;
use App\Models\Appointment;
use App\Services\InspectionFeeService;
use Livewire\Component;

class SelectInspectionType extends Component
{
    public Appointment $appointment;

    public function selectInspectionType(string $inspectionType)
    {
        $this->appointment->update([
            'inspection_type' => InspectionType::from($inspectionType)->value
        ]);

        // Dispatch event to update progress component
        $this->dispatch('appointment-updated', $this->appointment->id);
        
        return $this->redirect(route('appointments.inspection-date.select', $this->appointment), true);
    }

    public function getInspectionPrice($inspectionType): float
    {
        $inspectionFeeService = app(InspectionFeeService::class);
        return $inspectionFeeService->getInspectionPrice($inspectionType);
    }

    public function render()
    {
        return view('livewire.appointments.select-inspection-type', [
            'inspectionTypes' => InspectionType::cases()
        ]);
    }
}
