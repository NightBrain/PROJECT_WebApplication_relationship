<?php

namespace App\Imports;

use App\Models\Junior;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JuniorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Junior([
            'code' => $row['code'],
            'name' => $row['name'],
            'photo' => null,
            'senior_id' => null,
            'is_random' => false,
        ]);
    }
}
