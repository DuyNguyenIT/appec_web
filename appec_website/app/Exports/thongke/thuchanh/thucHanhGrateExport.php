<?php

namespace App\Exports\thongke\thuchanh;

use Session;
use App\Models\deThi;
use App\Models\hocPhan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class thucHanhGrateExport implements FromView
{

    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
         //học phần 
         $hp=hocPhan::where('isDelete',false)
         ->where('maHocPhan',Session::get('maHocPhan'))
         ->first();
        
         
         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',Session::get('maGV'))
             ->where('phieu_cham.isDelete',false);
         })
         ->get(['maPhieuCham','diemChu']);
         if($dethi->count()==0)
         {
             alert()->warning('There are no examination!','Message');
             return redirect('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
         $diemChu=[];
         $tiLe=[];
         $letter=['A','B+','B','C+','C','D+','D','F'];
         foreach ($letter as  $lt) {
             array_push($diemChu,$dethi->where('diemChu',$lt)->count());
             array_push($tiLe,number_format($dethi->where('diemChu',$lt)->count()*100/$dethi->count(),2));
         }
         
         return view('layouts.thongke.thongke_diemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
         'hp'=>$hp,'chu'=>$letter]);
    }
}
