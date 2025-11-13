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

    protected function baseFilteredQuery()
    {
        $query = QuotationRequest::query()
            ->whereHas('inspection.appointment.vehicle', function ($q) {
                $q->where('user_id', Auth::id());
            });

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('number', 'like', '%' . $this->search . '%')
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

        return $query;
    }

    public function getQuotationRequestsProperty()
    {
        return $this->baseFilteredQuery()
            ->with([
                'inspection.appointment.vehicle',
                'quotations.provider',
                'quotations.quotationSpareparts.damageSparepart.sparepart',
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getStatisticsProperty()
    {
        $query = $this->baseFilteredQuery();

        $total = (clone $query)->count();

        $statusCounts = (clone $query)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $typeCounts = (clone $query)
            ->selectRaw('type, COUNT(*) as aggregate')
            ->groupBy('type')
            ->pluck('aggregate', 'type');

        $awaiting = ($statusCounts['open'] ?? 0) + ($statusCounts['pending'] ?? 0);
        $fulfilled = $statusCounts['quoted'] ?? 0;
        $cancelled = $statusCounts['cancelled'] ?? 0;
        $expired = $statusCounts['expired'] ?? 0;
        $completionRate = $total > 0 ? (int) round(($fulfilled / $total) * 100) : 0;

        $thisMonth = (clone $query)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $latest = (clone $query)
            ->with(['inspection.appointment.vehicle'])
            ->orderByDesc('created_at')
            ->first();

        return [
            'total' => $total,
            'awaiting' => $awaiting,
            'fulfilled' => $fulfilled,
            'cancelled' => $cancelled,
            'expired' => $expired,
            'statusCounts' => [
                'open' => $statusCounts['open'] ?? 0,
                'pending' => $statusCounts['pending'] ?? 0,
                'quoted' => $statusCounts['quoted'] ?? 0,
                'cancelled' => $cancelled,
                'expired' => $expired,
            ],
            'typeCounts' => [
                'repair' => $typeCounts['repair'] ?? 0,
                'spare-parts' => $typeCounts['spare-parts'] ?? 0,
            ],
            'completionRate' => $completionRate,
            'thisMonth' => $thisMonth,
            'latest' => $latest,
        ];
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
            'statistics' => $this->statistics,
        ]);
    }
}
