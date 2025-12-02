<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FloorTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Return empty rows for skeleton file - user will fill the data
        // Providing 5 empty rows for user to fill
        // ID is auto-generated, so only Tower ID, Floor Name, and Status columns
        return [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tower ID',
            'Floor Name',
            'Status',
        ];
    }
}

