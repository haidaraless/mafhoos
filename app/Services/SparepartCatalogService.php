<?php

namespace App\Services;

use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;

class SparepartCatalogService
{
    private $csvPath;
    private $catalogData = [];

    public function __construct()
    {
        $this->csvPath = public_path('spareparts_catalog.csv');
        $this->loadCatalogData();
    }

    /**
     * Load catalog data from CSV file
     */
    private function loadCatalogData()
    {
        if (!file_exists($this->csvPath)) {
            return;
        }

        $handle = fopen($this->csvPath, 'r');
        if (!$handle) {
            return;
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return;
        }

        $this->catalogData = [];
        while (($row = fgetcsv($handle)) !== false) {
            $this->catalogData[] = array_combine($header, $row);
        }

        fclose($handle);
    }

    /**
     * Search spare parts in catalog
     */
    public function searchSpareparts($query, $vehicleMake = null, $vehicleModel = null, $vehicleYear = null, $category = null, $limit = 50)
    {
        if (empty($this->catalogData)) {
            return [];
        }

        $results = array_filter($this->catalogData, function ($part) use ($query, $vehicleMake, $vehicleModel, $vehicleYear, $category) {
            $matchesQuery = empty($query) || 
                stripos($part['name'], $query) !== false || 
                stripos($part['description'], $query) !== false ||
                stripos($part['part_number'], $query) !== false;

            $matchesMake = empty($vehicleMake) || 
                stripos($part['vehicle_make'], $vehicleMake) !== false;

            $matchesModel = empty($vehicleModel) || 
                stripos($part['vehicle_model'], $vehicleModel) !== false;

            $matchesYear = empty($vehicleYear) || $this->isYearCompatible($part['year_range'], $vehicleYear);

            $matchesCategory = empty($category) || 
                stripos($part['category'], $category) !== false;

            return $matchesQuery && $matchesMake && $matchesModel && $matchesYear && $matchesCategory;
        });

        return array_slice($results, 0, $limit);
    }

    /**
     * Check if vehicle year is compatible with part year range
     */
    private function isYearCompatible($yearRange, $vehicleYear)
    {
        if (empty($yearRange) || empty($vehicleYear)) {
            return true;
        }

        // Parse year range like "2015-2023" or "2015"
        if (strpos($yearRange, '-') !== false) {
            [$startYear, $endYear] = explode('-', $yearRange);
            return $vehicleYear >= trim($startYear) && $vehicleYear <= trim($endYear);
        } else {
            // Single year or exact match
            return $vehicleYear == trim($yearRange);
        }
    }

    /**
     * Get all available vehicle makes
     */
    public function getVehicleMakes()
    {
        if (empty($this->catalogData)) {
            return [];
        }

        $makes = array_unique(array_column($this->catalogData, 'vehicle_make'));
        sort($makes);
        return $makes;
    }

    /**
     * Get models for a specific make
     */
    public function getVehicleModels($make)
    {
        if (empty($this->catalogData)) {
            return [];
        }

        $models = array_filter($this->catalogData, function ($part) use ($make) {
            return stripos($part['vehicle_make'], $make) !== false;
        });

        $models = array_unique(array_column($models, 'vehicle_model'));
        sort($models);
        return $models;
    }

    /**
     * Get all available categories
     */
    public function getCategories()
    {
        if (empty($this->catalogData)) {
            return [];
        }

        $categories = array_unique(array_column($this->catalogData, 'category'));
        sort($categories);
        return $categories;
    }

    /**
     * Import catalog data to database
     */
    public function importToDatabase()
    {
        if (empty($this->catalogData)) {
            return false;
        }

        DB::transaction(function () {
            foreach ($this->catalogData as $partData) {
                Sparepart::updateOrCreate(
                    ['number' => $partData['part_number']],
                    [
                        'name' => $partData['name'],
                        'description' => $partData['description'],
                        'brand' => $partData['brand'],
                        'vehicle_make' => $partData['vehicle_make'],
                        'vehicle_model' => $partData['vehicle_model'],
                        'year_range' => $partData['year_range'],
                        'category' => $partData['category'],
                        'price_range' => $partData['price_range'],
                        'availability' => $partData['availability'],
                    ]
                );
            }
        });

        return true;
    }

    /**
     * Get catalog statistics
     */
    public function getCatalogStats()
    {
        if (empty($this->catalogData)) {
            return [
                'total_parts' => 0,
                'makes' => 0,
                'models' => 0,
                'categories' => 0,
            ];
        }

        return [
            'total_parts' => count($this->catalogData),
            'makes' => count($this->getVehicleMakes()),
            'models' => count(array_unique(array_column($this->catalogData, 'vehicle_model'))),
            'categories' => count($this->getCategories()),
        ];
    }

    /**
     * Refresh catalog data from CSV
     */
    public function refreshCatalog()
    {
        $this->loadCatalogData();
        return !empty($this->catalogData);
    }
}
