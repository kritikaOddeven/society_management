<?php

namespace App\Imports;

use App\Models\Tower;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TowerImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle status conversion
        $status = true;
        if (isset($row['status'])) {
            $statusValue = strtolower(trim($row['status']));
            $status = in_array($statusValue, ['active', '1', 'true', 'yes']);
        }

        return new Tower([
            'tower_name' => $row['tower_name'] ?? $row['tower name'] ?? '',
            'status' => $status,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'tower_name' => 'required|string|max:100',
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

