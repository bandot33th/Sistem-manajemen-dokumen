<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;

class MasterListSheetImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        // Load the file and get sheet names
        $file = request()->file('file');
        $spreadsheet = Excel::toArray(null, $file);

        $sheets = [];

        foreach ($spreadsheet as $index => $sheetData) {
            // You can add logic to dynamically match the slug or sheet name here
            $sheets["sheet_{$index}"] = new MasterListImport(); // Assuming every sheet uses MasterListImport
        }

        return $sheets;
    }

}
