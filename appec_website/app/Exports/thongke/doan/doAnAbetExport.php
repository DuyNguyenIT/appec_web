<?php

namespace App\Exports\thongke\doan;

use Session;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;

class doAnAbetExport implements FromView
{
    public function view(): View
    {
        $bieuDo=xuLyThongKeController::thong_ke_abet_do_an(Session::get('maCTBaiQH'),Session::get('maCanBo'));
        return view('layouts.thongke.thongke_abet',['bieuDo'=>$bieuDo]);
    }
}
