<?php

namespace App\Imports;

use App\Models\Senior;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SeniorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Senior([
            'code' => $row['code'],
            'name' => $row['name'],
            'max_juniors' => isset($row['max_juniors']) ? (int)$row['max_juniors'] : 1,
            'photo' => null,
            'status' => 'available',
            'current_juniors' => 0,
        ]);
    }
}
