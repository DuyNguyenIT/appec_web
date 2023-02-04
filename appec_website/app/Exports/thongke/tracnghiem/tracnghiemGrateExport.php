<?php

namespace App\Exports\thongke\tracnghiem;

use Session;
use App\Models\deThi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\xuLyThongKeController;

class tracnghiemGrateExport implements FromView
{
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        //check de thi
        $dethi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();

        $diemChu=xuLyThongKeController::thong_ke_diem_chu($maCTBaiQH,session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_le_ti_le_diem_chu($maCTBaiQH,session::get('maGV'));
        $letter=['A','B+','B','C+','C','D+','D','F'];
        return view('layouts.thongke.thongke_diemchu',['diemChu'=>$diemChu,
        'tiLe'=>$tiLe,'chu'=>$letter]);
    }
}
