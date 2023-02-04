<?php

namespace App\Exports\thongke\thuchanh;

use Session;
use App\Models\deThi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\xuLyThongKeController;

class thucHanhRankExport implements FromView
{
    
    public function view(): View
    {
        
        $maCTBaiQH=Session::get('maCTBaiQH');
         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)->get();
        //xếp hạng
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));
        return view('layouts.thongke.thongke_xepHang',['xepHang'=>$xepHang,
        'tiLe'=>$tiLe]);
    }
}
