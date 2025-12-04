<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\ApartmentType;
use App\Models\Owner;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ApartmentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Get tower_id
        $towerId = null;
        if (isset($row['tower_id']) && !empty($row['tower_id'])) {
            $towerId = $row['tower_id'];
        } elseif (isset($row['tower name']) || isset($row['tower_name'])) {
            $towerName = trim($row['tower name'] ?? $row['tower_name'] ?? '');
            if (!empty($towerName)) {
                $tower = Tower::where('tower_name', $towerName)->first();
                if ($tower) {
                    $towerId = $tower->id;
                }
            }
        }

        if (!$towerId) {
            return null;
        }

        // Get floor_id
        $floorId = null;
        if (isset($row['floor_id']) && !empty($row['floor_id'])) {
            $floorId = $row['floor_id'];
        } elseif (isset($row['floor name']) || isset($row['floor_name'])) {
            $floorName = trim($row['floor name'] ?? $row['floor_name'] ?? '');
            if (!empty($floorName)) {
                $floor = Floor::where('floor_name', $floorName)->where('tower_id', $towerId)->first();
                if ($floor) {
                    $floorId = $floor->id;
                }
            }
        }

        if (!$floorId) {
            return null;
        }

        // Get apartment_type
        $apartmentTypeId = null;
        if (isset($row['apartment_type_id']) && !empty($row['apartment_type_id'])) {
            $apartmentTypeId = $row['apartment_type_id'];
        } elseif (isset($row['apartment type id']) && !empty($row['apartment type id'])) {
            $apartmentTypeId = $row['apartment type id'];
        } elseif (isset($row['apartment_type']) || isset($row['apartment type'])) {
            $typeName = trim($row['apartment type'] ?? $row['apartment_type'] ?? '');
            if (!empty($typeName)) {
                $type = ApartmentType::where('apartment_type', $typeName)->first();
                if ($type) {
                    $apartmentTypeId = $type->id;
                }
            }
        }

        if (!$apartmentTypeId) {
            return null;
        }

        // Get apartment number
        $apartmentNumber = trim($row['apartment_number'] ?? $row['apartment number'] ?? '');
        if (empty($apartmentNumber)) {
            return null;
        }

        // Get apartment area
        $apartmentArea = trim($row['apartment_area'] ?? $row['apartment area'] ?? '');
        if (empty($apartmentArea)) {
            return null;
        }

        // Handle status - default to 'Unsold'
        $status = 'Unsold';
        if (isset($row['status']) && !empty($row['status'])) {
            $statusValue = ucfirst(strtolower(trim($row['status'])));
            if (in_array($statusValue, ['Unsold', 'Occupied', 'Rent', 'Rented'])) {
                $status = $statusValue;
            }
        }

        // Get owner_id if provided
        $ownerId = null;
        if (isset($row['owner_id']) && !empty($row['owner_id'])) {
            $ownerId = $row['owner_id'];
        } elseif (isset($row['owner id']) && !empty($row['owner id'])) {
            $ownerId = $row['owner id'];
        }

        // Get parking_id if provided (can be JSON array or comma-separated)
        $parkingId = '';
        if (isset($row['parking_id']) && !empty($row['parking_id'])) {
            $parkingValue = $row['parking_id'];
            // Check if it's already JSON
            if (is_string($parkingValue) && (strpos($parkingValue, '[') === 0 || strpos($parkingValue, ',') !== false)) {
                // If comma-separated, convert to array then JSON
                if (strpos($parkingValue, ',') !== false) {
                    $parkingArray = array_map('trim', explode(',', $parkingValue));
                    $parkingId = json_encode($parkingArray);
                } else {
                    $parkingId = $parkingValue;
                }
            } elseif (is_numeric($parkingValue)) {
                // Single parking ID
                $parkingId = json_encode([$parkingValue]);
            }
        } elseif (isset($row['parking id']) && !empty($row['parking id'])) {
            $parkingValue = $row['parking id'];
            if (is_string($parkingValue) && strpos($parkingValue, ',') !== false) {
                $parkingArray = array_map('trim', explode(',', $parkingValue));
                $parkingId = json_encode($parkingArray);
            } elseif (is_numeric($parkingValue)) {
                $parkingId = json_encode([$parkingValue]);
            }
        }

        return new Apartment([
            'tower_id' => $towerId,
            'floor_id' => $floorId,
            'apartment_number' => $apartmentNumber,
            'apartment_area' => $apartmentArea,
            'apartment_type' => $apartmentTypeId,
            'status' => $status,
            'parking_id' => $parkingId,
            'owner_id' => $ownerId,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'tower_id' => 'nullable',
            'tower_name' => 'nullable',
            'tower name' => 'nullable',
            'floor_id' => 'nullable',
            'floor_name' => 'nullable',
            'floor name' => 'nullable',
            'apartment_number' => 'required|string|max:50',
            'apartment number' => 'nullable|string|max:50',
            'apartment_area' => 'required|numeric|min:1|max:10000',
            'apartment area' => 'nullable|numeric|min:1|max:10000',
            'apartment_type_id' => 'nullable',
            'apartment type id' => 'nullable',
            'apartment_type' => 'nullable',
            'apartment type' => 'nullable',
            'status' => 'nullable|string',
            'parking_id' => 'nullable',
            'parking id' => 'nullable',
            'owner_id' => 'nullable',
            'owner id' => 'nullable',
        ];
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }
}

