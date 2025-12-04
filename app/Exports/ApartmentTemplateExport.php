<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApartmentTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Return empty rows for skeleton file - user will fill the data
        // Providing 5 empty rows for user to fill
        return [
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tower ID',
            'Floor ID',
            'Apartment Number',
            'Apartment Area',
            'Apartment Type ID',
            'Status',
            'Parking ID',
            'Owner ID',
        ];
    }
}

