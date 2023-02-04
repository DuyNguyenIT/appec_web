<?php

namespace App\Exports\thongke\thuchanh;
use Session;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;

class thucHanhSOExport implements FromView
{
    public function view(): View
    {
        
        $bieuDo=xuLyThongKeController::thong_ke_CDR3(Session::get('maCTBaiQH'));
         return view('layouts.thongke.thong_ke_so',['bieuDo'=>$bieuDo]);
    }
}
