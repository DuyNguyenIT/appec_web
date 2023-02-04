<?php

namespace App\Exports\thongke\doan;
use Session;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;

class doAnCLOExport implements FromView
{
    public function view():View
    {
        $bieuDo=xuLyThongKeController::thong_ke_clo_do_an(Session::get('maCTBaiQH'),Session::get('maCanBo'));
        return view('layouts.thongke.thongke_clo',compact('bieuDo'));
    }
}
