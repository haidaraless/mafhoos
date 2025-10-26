<?php

namespace App\Livewire\Settings;

use App\Services\SparepartCatalogService;
use Livewire\Component;
use Livewire\WithFileUploads;

class  SparepartCatalog extends Component
{
    use WithFileUploads;

    public $searchQuery = '';
    public $selectedMake = '';
    public $selectedModel = '';
    public $selectedCategory = '';
    public $catalogStats = [];
    public $searchResults = [];
    public $vehicleMakes = [];
    public $vehicleModels = [];
    public $categories = [];
    public $showImportModal = false;
    public $csvFile;
    public $importProgress = 0;
    public $importStatus = '';

    protected $rules = [
        'csvFile' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
    ];

    public function mount()
    {
        $this->loadCatalogData();
    }

    public function loadCatalogData()
    {
        $catalogService = new SparepartCatalogService();
        
        $this->catalogStats = $catalogService->getCatalogStats();
        $this->vehicleMakes = $catalogService->getVehicleMakes();
        $this->categories = $catalogService->getCategories();
        
        $this->performSearch();
    }

    public function updatedSearchQuery()
    {
        $this->performSearch();
    }

    public function updatedSelectedMake()
    {
        $catalogService = new SparepartCatalogService();
        $this->vehicleModels = $catalogService->getVehicleModels($this->selectedMake);
        $this->selectedModel = '';
        $this->performSearch();
    }

    public function updatedSelectedModel()
    {
        $this->performSearch();
    }

    public function updatedSelectedCategory()
    {
        $this->performSearch();
    }

    public function performSearch()
    {
        $catalogService = new SparepartCatalogService();
        
        $this->searchResults = $catalogService->searchSpareparts(
            $this->searchQuery,
            $this->selectedMake,
            $this->selectedModel,
            null, // No year filtering in management interface
            $this->selectedCategory,
            50
        );
    }

    public function clearFilters()
    {
        $this->searchQuery = '';
        $this->selectedMake = '';
        $this->selectedModel = '';
        $this->selectedCategory = '';
        $this->vehicleModels = [];
        $this->performSearch();
    }

    public function showImportModal()
    {
        $this->showImportModal = true;
        $this->reset(['csvFile', 'importProgress', 'importStatus']);
    }

    public function hideImportModal()
    {
        $this->showImportModal = false;
        $this->reset(['csvFile', 'importProgress', 'importStatus']);
    }

    public function importCatalog()
    {
        $this->validate();

        try {
            $this->importStatus = 'Uploading file...';
            $this->importProgress = 10;

            // Store the uploaded file
            $path = $this->csvFile->store('temp');
            $fullPath = storage_path('app/' . $path);

            $this->importStatus = 'Processing CSV...';
            $this->importProgress = 30;

            // Copy to the main catalog location
            copy($fullPath, storage_path('app/spareparts_catalog.csv'));

            $this->importStatus = 'Importing to database...';
            $this->importProgress = 60;

            // Import to database
            $catalogService = new SparepartCatalogService();
            $catalogService->refreshCatalog();
            $success = $catalogService->importToDatabase();

            if ($success) {
                $this->importStatus = 'Import completed successfully!';
                $this->importProgress = 100;
                
                // Clean up temp file
                unlink($fullPath);
                
                // Reload catalog data
                $this->loadCatalogData();
                
                session()->flash('message', 'Spare parts catalog imported successfully!');
                
                // Close modal after a short delay
                $this->dispatch('import-completed');
            } else {
                $this->importStatus = 'Import failed. Please check your CSV file.';
                $this->importProgress = 0;
            }

        } catch (\Exception $e) {
            $this->importStatus = 'Error: ' . $e->getMessage();
            $this->importProgress = 0;
        }
    }

    public function downloadSampleCsv()
    {
        return response()->download(storage_path('app/spareparts_catalog.csv'), 'spareparts_catalog_sample.csv');
    }

    public function render()
    {
        return view('livewire.settings.sparepart-catalog');
    }
}