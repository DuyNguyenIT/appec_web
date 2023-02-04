<?php

namespace App\Exports\thongke\thuchanh;

use Session;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;


class thucHanhCLOExport implements FromView
{
  
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $bieuDo=xuLyThongKeController::thong_ke_kqht($maCTBaiQH);
      
        return view('layouts.thongke.thongke_clo',compact('bieuDo'));
    }
}
