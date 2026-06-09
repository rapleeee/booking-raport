<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaPreviewImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Not used directly, we'll use Excel::toArray
    }
}
