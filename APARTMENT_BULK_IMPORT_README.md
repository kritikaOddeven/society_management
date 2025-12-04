# Apartment Bulk Import Documentation

This document explains how to use the bulk import functionality for apartments in the Society Management System.

## Overview

The apartment bulk import feature allows you to import multiple apartments at once using an Excel file (.xlsx or .xls). This is similar to the existing tower and floor bulk import functionality.

## Features Implemented

### 1. Template Export
- **Route:** `/apartments/download-template`
- **Method:** GET
- **Description:** Downloads an empty Excel template with the correct column headers
- **Columns:** Tower ID, Floor ID, Apartment Number, Apartment Area, Apartment Type ID, Status, Parking ID, Owner ID

### 2. Data Export
- **Route:** `/apartments/export`
- **Method:** GET
- **Description:** Exports all existing apartments to Excel with complete data
- **Use Case:** View current apartment data or create example files

### 3. Example Export
- **Route:** `/apartments/download-example`
- **Method:** GET
- **Description:** Downloads a sample Excel file with example apartment data

### 4. Reference Downloads
- **Towers Reference:** `/apartments/download-towers`
- **Floors Reference:** `/apartments/download-floors`
- **Description:** Download reference files to get valid Tower IDs and Floor IDs

### 5. Bulk Import
- **Route:** `/apartments/import`
- **Method:** POST
- **Description:** Import apartments from an uploaded Excel file
- **File Size Limit:** 10MB
- **Supported Formats:** .xlsx, .xls

## How to Use

### Step 1: Download Template
1. Navigate to Apartments → Bulk Upload
2. Click "Download Template Excel" to get the empty template
3. OR click "Download Example Excel" to see a sample file

### Step 2: Get Reference IDs
1. Click "Download Towers" to get a list of all tower IDs
2. Click "Download Floors" to get a list of all floor IDs
3. Note: You can also find Apartment Type IDs and Owner IDs in their respective sections

### Step 3: Fill the Excel File

#### Required Fields:
- **Tower ID**: Must exist in the system
- **Floor ID**: Must exist in the system and belong to the specified tower
- **Apartment Number**: Unique identifier for the apartment (max 50 characters)
- **Apartment Area**: Numeric value between 1 and 10,000 (in square feet)
- **Apartment Type ID**: Must exist in the system

#### Optional Fields:
- **Status**: One of: Unsold (default), Occupied, Rent, Rented
- **Parking ID**: Can be a single ID or multiple IDs separated by commas (e.g., "1,2,3")
- **Owner ID**: Must exist in the system if provided

#### Example Row:
```
Tower ID: 1
Floor ID: 5
Apartment Number: 101
Apartment Area: 1200
Apartment Type ID: 2
Status: Occupied
Parking ID: 3,4
Owner ID: 10
```

### Step 4: Upload the File
1. Click "Browse" to select your filled Excel file
2. Click "Upload Excel" to import the data
3. Wait for the upload to complete

### Step 5: Review Results
- **Success:** All apartments imported successfully
- **Partial Success:** Some rows imported, others skipped due to errors
- **Error:** No apartments imported, check error messages

## Files Created/Modified

### New Files:
1. `app/Exports/ApartmentTemplateExport.php` - Template export class
2. `app/Exports/ApartmentExport.php` - Data export class
3. `app/Imports/ApartmentImport.php` - Data import class with validation
4. `resources/views/apartments/bulk-upload.blade.php` - Bulk upload UI

### Modified Files:
1. `app/Http/Controllers/ApartmentController.php` - Added bulk upload methods
2. `routes/web.php` - Added apartment bulk import routes
3. `resources/views/apartments/index.blade.php` - Added bulk upload and export buttons

## Technical Details

### Import Process
The import uses Laravel Excel (Maatwebsite/Excel) with the following features:
- **Batch Inserts:** Processes 100 rows at a time for efficiency
- **Chunk Reading:** Reads 100 rows at a time to manage memory
- **Error Handling:** Skips invalid rows and continues processing
- **Validation:** Validates each row before importing
- **Flexible Input:** Accepts both IDs and names for tower/floor/type lookup

### Validation Rules
```php
- Tower ID: Required (either as ID or name)
- Floor ID: Required (either as ID or name, must belong to tower)
- Apartment Number: Required, max 50 characters, must be unique
- Apartment Area: Required, numeric, between 1 and 10,000
- Apartment Type: Required (either as ID or name)
- Status: Optional, must be one of: Unsold, Occupied, Rent, Rented
- Parking ID: Optional, can be comma-separated for multiple
- Owner ID: Optional, must exist in system
```

## Routes Summary

```php
// Apartment Bulk Import Routes (defined before resource routes)
GET  /apartments/bulk-upload          - Show bulk upload page
GET  /apartments/export               - Export all apartments
GET  /apartments/download-template    - Download template file
GET  /apartments/download-example     - Download example file
GET  /apartments/download-towers      - Download towers reference
GET  /apartments/download-floors      - Download floors reference
POST /apartments/import               - Import from Excel file
```

## Important Notes

1. **Route Order:** Specific routes are defined BEFORE the resource route to prevent conflicts
2. **File Size:** Maximum upload size is 10MB
3. **Data Integrity:** All foreign key relationships are validated before import
4. **Duplicate Detection:** Apartment numbers must be unique across the system
5. **Error Handling:** Invalid rows are skipped, valid rows are still imported
6. **Parking Assignment:** Multiple parking spaces can be assigned using comma-separated IDs

## Troubleshooting

### Common Issues:

1. **"Tower not found"**
   - Ensure the Tower ID exists in the system
   - Download the towers reference file to verify IDs

2. **"Floor not found"**
   - Ensure the Floor ID exists and belongs to the specified tower
   - Download the floors reference file to verify IDs

3. **"Apartment number already exists"**
   - Each apartment number must be unique
   - Check existing apartments before importing

4. **"Apartment type not found"**
   - Ensure the Apartment Type ID exists in the system
   - Check Settings → Apartment Types

5. **File upload fails**
   - Check file size (must be < 10MB)
   - Ensure file format is .xlsx or .xls
   - Verify file is not corrupted

## Future Enhancements

Potential improvements that could be added:
- Validation preview before actual import
- Download failed rows as Excel file
- Support for updating existing apartments
- Image/document upload during bulk import
- Apartment type creation during import if not exists

## Support

For issues or questions, please contact the development team or refer to the main system documentation.

