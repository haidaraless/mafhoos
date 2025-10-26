# Spare Parts Catalog System

This document explains how to use the new spare parts catalog system that allows searching and selecting spare parts from a CSV database.

## Features

- **CSV Import**: Import spare parts data from CSV files
- **Advanced Search**: Search by part name, description, part number, vehicle make/model, and category
- **Real-time Search**: Live search results as you type
- **Damage Sparepart Integration**: Seamlessly integrate with the existing damage sparepart functionality
- **Database Storage**: Automatically stores selected parts in the database

## CSV Format

The system expects CSV files with the following columns:

```csv
part_number,name,description,brand,vehicle_make,vehicle_model,year_range,category,price_range,availability
ACF001,Air Filter,Engine air filter for improved performance,ACDelco,Toyota,Camry,2015-2023,Engine,15-25,In Stock
```

### Required Columns:
- `part_number`: Unique identifier for the part
- `name`: Part name
- `description`: Detailed description
- `brand`: Manufacturer brand
- `vehicle_make`: Vehicle manufacturer (e.g., Toyota, Honda, Ford)
- `vehicle_model`: Vehicle model (e.g., Camry, Accord, F-150)
- `year_range`: Year range (e.g., 2015-2023)
- `category`: Part category (e.g., Engine, Brakes, Suspension)
- `price_range`: Price range (e.g., 15-25)
- `availability`: Stock status (e.g., In Stock, Out of Stock)

## Usage

### 1. Accessing the Catalog Management

Navigate to **Settings > Spare Parts Catalog** to:
- View catalog statistics
- Search and filter parts
- Import new CSV files
- Download sample CSV

### 2. Importing CSV Data

1. Go to Settings > Spare Parts Catalog
2. Click "Import CSV"
3. Select your CSV file
4. Click "Import" to start the process
5. The system will automatically import all parts to the database

### 3. Using in Damage Sparepart Selection

When creating an inspection report:

1. Navigate to the inspection report page
2. In the "Damage Spareparts" section, start typing in the search box
3. The system will search both the CSV catalog and existing database
4. Select parts from the dropdown results
5. Set priority levels for each selected part
6. Save the report

### 4. Command Line Import

You can also import the catalog using the command line:

```bash
# Import the default catalog
php artisan spareparts:import

# Refresh catalog from CSV file
php artisan spareparts:import --refresh
```

## Search Functionality

The search system supports:

- **Text Search**: Search by part name, description, or part number
- **Vehicle Filter**: Filter by specific vehicle make and model
- **Category Filter**: Filter by part category
- **Combined Filters**: Use multiple filters together for precise results

## Sample Data

The system comes with a sample CSV file containing 74 spare parts for:
- **Vehicle Makes**: Toyota, Honda, Ford
- **Vehicle Models**: Camry, Accord, F-150
- **Categories**: Engine, Brakes, Suspension, Cooling, Electrical, Exhaust, Fuel, Tires, Exterior, Lighting

## File Locations

- **CSV File**: `storage/app/spareparts_catalog.csv`
- **Service Class**: `app/Services/SparepartCatalogService.php`
- **Management Component**: `app/Livewire/Settings/SparepartCatalog.php`
- **Integration**: `app/Livewire/Inspections/ReportInspection.php`

## Database Schema

The `spareparts` table includes these additional fields:
- `description` (text)
- `brand` (string)
- `vehicle_make` (string)
- `vehicle_model` (string)
- `year_range` (string)
- `category` (string)
- `price_range` (string)
- `availability` (string)

## Troubleshooting

### No Search Results
- Ensure the CSV file exists at `storage/app/spareparts_catalog.csv`
- Check that the CSV file has the correct format
- Try importing the catalog using the management interface

### Import Errors
- Verify CSV file format matches the expected structure
- Check file permissions for the storage directory
- Ensure the database migration has been run

### Performance Issues
- The system limits search results to 50 items by default
- Large CSV files may take time to process
- Consider breaking very large catalogs into smaller files
