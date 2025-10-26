<?php

namespace App\Livewire\Inspections;

use App\Enums\Priority;
use App\Models\Inspection;
use App\Models\Sparepart;
use App\Models\Appointment;
use Livewire\Component;

class ReportInspection extends Component
{
    public Inspection $inspection;

    public Appointment $appointment;
    // Form fields
    public string $report = '';
    public string $sparepartSearch = '';
    public array $selectedSpareparts = [];
    public array $sparepartPriorities = [];
    
    public $sparepartSearchResults = [];

    public function mount(Inspection $inspection)
    {
        $this->inspection = $inspection;

        $this->appointment = Appointment::find($inspection->appointment_id);
        
        // Load existing damage spareparts
        $this->loadExistingDamageSpareparts();
    }

    public function updatedSparepartSearch()
    {
        if (strlen($this->sparepartSearch) < 2) {
            $this->sparepartSearchResults = [];
            return;
        }

        $this->sparepartSearchResults = Sparepart::where('name', 'like', '%' . $this->sparepartSearch . '%')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function selectSparepart($sparepartId)
    {
        $sparepart = Sparepart::find($sparepartId);
        
        if ($sparepart && !in_array($sparepartId, $this->selectedSpareparts)) {
            $this->selectedSpareparts[] = $sparepartId;
            $this->sparepartPriorities[$sparepartId] = Priority::MEDIUM->value;
        }
        
        $this->sparepartSearch = '';
        $this->sparepartSearchResults = [];
    }

    public function removeSparepart($sparepartId)
    {
        $this->selectedSpareparts = array_filter($this->selectedSpareparts, fn($id) => $id !== $sparepartId);
        unset($this->sparepartPriorities[$sparepartId]);
    }

    public function updatePriority($sparepartId, $priority)
    {
        $this->sparepartPriorities[$sparepartId] = $priority;
    }

    public function saveReport()
    {
        $this->validate([
            'report' => 'required|string|min:10',
        ]);

        // Update inspection report
        $this->inspection->update([
            'report' => $this->report,
            'completed_at' => now(),
        ]);

        // Save damage spareparts
        foreach ($this->selectedSpareparts as $sparepartId) {
            $this->inspection->damageSpareparts()->updateOrCreate(
                ['sparepart_id' => $sparepartId],
                [
                    'priority' => $this->sparepartPriorities[$sparepartId] ?? Priority::MEDIUM->value,
                ]
            );
        }

        // Remove spareparts that are no longer selected
        $this->inspection->damageSpareparts()
            ->whereNotIn('sparepart_id', $this->selectedSpareparts)
            ->delete();

        session()->flash('message', 'Inspection report saved successfully!');
        
        return redirect()->route('dashboard.inspection-center');
    }

    private function loadExistingDamageSpareparts()
    {
        $existingDamageSpareparts = $this->inspection->damageSpareparts()->with('sparepart')->get();
        
        foreach ($existingDamageSpareparts as $damageSparepart) {
            $this->selectedSpareparts[] = $damageSparepart->sparepart_id;
            $this->sparepartPriorities[$damageSparepart->sparepart_id] = $damageSparepart->priority->value;
        }
        
        if ($this->inspection->report) {
            $this->report = $this->inspection->report;
        }
    }

    public function getSelectedSparepartsProperty()
    {
        if (empty($this->selectedSpareparts)) {
            return collect();
        }
        
        return Sparepart::whereIn('id', $this->selectedSpareparts)->get();
    }

    public function render()
    {
        return view('livewire.inspections.report-inspection');
    }
}