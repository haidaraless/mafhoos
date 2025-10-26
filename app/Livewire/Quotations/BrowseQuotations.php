<?php

namespace App\Livewire\Quotations;

use App\Models\QuotationRequest;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseQuotations extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $vehicleFilter = '';

    public function mount()
    {
        // Initialize any default values if needed
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedVehicleFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->vehicleFilter = '';
        $this->resetPage();
    }

    public function getQuotationRequestsProperty()
    {
        $query = QuotationRequest::with([
            'inspection.appointment.vehicle',
            'quotations.provider',
            'quotations.quotationSpareparts.damageSparepart.sparepart'
        ])
        ->whereHas('inspection.appointment.vehicle', function ($q) {
            $q->where('user_id', Auth::user()->id);
        });

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('inspection.appointment.vehicle', function ($vehicleQuery) {
                      $vehicleQuery->where('make', 'like', '%' . $this->search . '%')
                                  ->orWhere('model', 'like', '%' . $this->search . '%')
                                  ->orWhere('vin', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply type filter
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        // Apply vehicle filter
        if ($this->vehicleFilter) {
            $query->whereHas('inspection.appointment.vehicle', function ($q) {
                $q->where('id', $this->vehicleFilter);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getUserVehiclesProperty()
    {
        return Vehicle::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function viewQuotationRequest($quotationRequestId)
    {
        return $this->redirect(route('quotation-requests.view', $quotationRequestId), true);
    }

    public function render()
    {
        return view('livewire.quotations.browse-quotations', [
            'quotationRequests' => $this->quotationRequests,
            'userVehicles' => $this->userVehicles,
        ]);
    }
}
