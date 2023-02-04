<?php

namespace App\Exports\thongke\thuchanh;

use Session;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;

class thucHanhAbetExport implements FromView
{

    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $bieuDo=xuLyThongKeController::thong_ke_abet($maCTBaiQH);
        return view('layouts.thongke.thongke_abet',['bieuDo'=>$bieuDo]);
    }
}
