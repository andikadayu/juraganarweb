<?php

namespace App\Exports;

use App\Models\ShopeeScrap;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ShopeeExport implements FromView
{
    public $date;
    public $id_user;

    public function __construct($id_user, $date)
    {
        $this->date = $date;
        $this->id_user = $id_user;
    }

    public function view(): View
    {
        return view();
    }
}
