<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\MGuru;


class MasterGuru implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MGuru::create([
                'name' => $row['name'],
                'no_hp' => $row['no_hp'],
                'gaji' => $row['gaji'],
            ]);
        }
    }
}
