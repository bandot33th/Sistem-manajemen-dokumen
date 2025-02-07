<?php

namespace App\Exports;

use App\Models\MasterList;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterListExport implements WithMultipleSheets
{
    protected $categoryId;
    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function sheets(): array
    {
        $masterLists = MasterList::where('category_master_list_id', $this->categoryId)->get();
        $groupedBySlug = $masterLists->groupBy('slug');

        $sheets = [];
        foreach ($groupedBySlug as $slug => $items) {
            $sheets[] = new MasterListSheet($slug, $items);
        }

        return $sheets;
    }
}
