<?php

namespace App\Imports;

use App\Models\Floor;
use App\Models\Tower;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FloorImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Get tower_id - can be from ID or tower name
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

        // If still no tower_id, skip this row (will be caught by validation)
        if (!$towerId) {
            return null;
        }

        // Handle status conversion
        $status = true;
        if (isset($row['status']) && !empty($row['status'])) {
            $statusValue = strtolower(trim($row['status']));
            $status = in_array($statusValue, ['active', '1', 'true', 'yes']);
        }

        $floorName = trim($row['floor_name'] ?? $row['floor name'] ?? '');
        if (empty($floorName)) {
            return null;
        }

        return new Floor([
            'tower_id' => $towerId,
            'floor_name' => $floorName,
            'status' => $status,
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
            'floor_name' => 'required|string|max:50',
            'floor name' => 'nullable|string|max:50',
            'status' => 'nullable|string',
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

