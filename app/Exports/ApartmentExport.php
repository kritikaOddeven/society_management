<?php

namespace App\Exports;

use App\Models\Apartment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApartmentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Apartment::with(['tower', 'floor', 'type', 'owner'])
            ->orderBy('tower_id')
            ->orderBy('floor_id')
            ->orderBy('apartment_number')
            ->get();
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
            'Floor ID',
            'Floor Name',
            'Apartment Number',
            'Apartment Area',
            'Apartment Type ID',
            'Apartment Type',
            'Status',
            'Parking IDs',
            'Owner ID',
            'Owner Name',
        ];
    }

    /**
     * @param mixed $apartment
     * @return array
     */
    public function map($apartment): array
    {
        return [
            $apartment->id,
            $apartment->tower_id,
            $apartment->tower->tower_name ?? '',
            $apartment->floor_id,
            $apartment->floor->floor_name ?? '',
            $apartment->apartment_number,
            $apartment->apartment_area,
            $apartment->apartment_type,
            $apartment->type->apartment_type ?? '',
            $apartment->status,
            $apartment->parking_id ?? '',
            $apartment->owner_id ?? '',
            $apartment->owner->name ?? '',
        ];
    }
}

