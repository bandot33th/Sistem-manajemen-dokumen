<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterListSheet implements FromView, WithTitle
{
    protected $slug;
    protected $items;
    public function __construct($slug, $items)
    {
        $this->slug = $slug;
        $this->items = $items;
    }

    public function view(): View
    {
        return view('exports.masterlist', [
            'masterLists' => $this->items,
        ]);
    }

    public function title(): string
    {
        return $this->slug;
    }
}
