<?php

namespace App\Exports;

use App\Models\Tower;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TowerExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tower::orderBy('tower_name')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Tower Name',
            'Status',
        ];
    }

    /**
     * @param mixed $tower
     * @return array
     */
    public function map($tower): array
    {
        return [
            $tower->id,
            $tower->tower_name,
            $tower->status ? 'Active' : 'Inactive',
        ];
    }
}

