<?php

namespace App\Console\Commands;

use App\Services\SparepartCatalogService;
use Illuminate\Console\Command;

class ImportSparepartsCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spareparts:import {--refresh : Refresh catalog data from CSV}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import spare parts catalog from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting spare parts catalog import...');

        $catalogService = new SparepartCatalogService();

        if ($this->option('refresh')) {
            $this->info('Refreshing catalog data from CSV...');
            $catalogService->refreshCatalog();
        }

        $stats = $catalogService->getCatalogStats();
        
        if ($stats['total_parts'] === 0) {
            $this->error('No catalog data found. Please ensure the CSV file exists at storage/app/spareparts_catalog.csv');
            return 1;
        }

        $this->info("Found {$stats['total_parts']} parts in catalog");
        $this->info("Vehicle makes: {$stats['makes']}");
        $this->info("Vehicle models: {$stats['models']}");
        $this->info("Categories: {$stats['categories']}");

        $this->info('Importing to database...');
        
        $bar = $this->output->createProgressBar($stats['total_parts']);
        $bar->start();

        $success = $catalogService->importToDatabase();

        $bar->finish();
        $this->newLine();

        if ($success) {
            $this->info('✅ Spare parts catalog imported successfully!');
        } else {
            $this->error('❌ Failed to import spare parts catalog');
            return 1;
        }

        return 0;
    }
}