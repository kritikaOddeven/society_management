<?php

namespace App\Exports;

use App\Models\Floor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FloorExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Floor::with('tower')->orderBy('tower_id')->orderBy('floor_name')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Tower ID',
            'Tower Name',
            'Floor Name',
            'Status',
        ];
    }

    /**
     * @param mixed $floor
     * @return array
     */
    public function map($floor): array
    {
        return [
            $floor->id,
            $floor->tower_id,
            $floor->tower->tower_name ?? '',
            $floor->floor_name,
            $floor->status ? 'Active' : 'Inactive',
        ];
    }
}

