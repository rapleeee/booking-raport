<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Ahmad Dahlan', 'X-RPL-1'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Nama Kelas',
        ];
    }
}
