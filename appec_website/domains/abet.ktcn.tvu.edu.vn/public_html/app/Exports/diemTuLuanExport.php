<?php

namespace App\Exports;
use Session;
use App\Models\deThi;
use App\Models\hocPhan;
use App\Models\ct_bai_quy_hoach;
use App\Models\sinhvien_hocphan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class diemTuLuanExport implements FromView
{
    
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');

        // loai hinh thuc danh gia
        $loaiHTDG=ct_bai_quy_hoach::where('maCTBaiQH',$maCTBaiQH)->first('maLoaiHTDG');

        //chi tiet bai quy hoach
        $ctbqh=ct_bai_quy_hoach::where('maCTBaiQH',$maCTBaiQH)->first();

        //thong tin hoc phan
        $hp=hocPhan::getHocPhanByMaHocPhan(Session::get('maHocPhan'));
        //danh sach de thi
        $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        //check sinh vien da chon
        $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
        //->Leftjoin('sinh_vien','sinh_vien.maSSV','=','phieu_cham.maSSV')
        ->pluck('phieu_cham.maSSV');

        //danh sach sinh vien
        $dssv=sinhvien_hocphan::where('maLop',Session::get('maLop'))
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->where('maHK',Session::get('maHK'))
        ->where('namHoc',Session::get('namHoc'))
        ->whereNotIn('maSSV',$svdachon)->get();

        //phieu cham
        $phieucham=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));
        //return $phieucham;
        return view('giangvien.ketqua.tuluan.ketquatuluan',compact('hp','dssv','deThi','phieucham'));
    }
}
