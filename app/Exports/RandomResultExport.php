<?php

namespace App\Exports;

use App\Models\Junior;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RandomResultExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Junior::with('senior')
            ->get()
            ->map(function ($junior) {
                return [
                    'junior_code' => $junior->code,
                    'junior_name' => $junior->name,
                    'senior_code' => $junior->senior ? $junior->senior->code : '-',
                    'senior_name' => $junior->senior ? $junior->senior->name : '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['รหัสน้อง', 'ชื่อน้อง', 'รหัสพี่', 'ชื่อพี่'];
    }
}
