<?php

namespace App\Exports\thongke\doan;
use Session;
use App\Models\deThi;
use App\Models\hocPhan;
use Illuminate\Contracts\View\View;
use App\Models\ct_bai_quy_hoach;
use Maatwebsite\Excel\Concerns\FromView;

class doAnGrateExport implements FromView
{

    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $maCanBo=Session::get('maCanBo');
        //học phần 
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->first();
        //ct bai quy hoach
        $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->leftjoin('loai_ht_danhgia',function($x){
            $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('ct_bai_quy_hoach.isDelete',false);
        })
        ->first();
        
        Session::put('maGV_2',$ct_baiQH->maGV_2);
        
        if ($maCanBo==1) {
           //phiếu chấm
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','diemChu']);
        } else {
             //phiếu chấm
             $dethi=deThi::where('de_thi.isDelete',false)
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('phieu_cham',function($x){
                 $x->on('phieu_cham.maDe','=','de_thi.maDe')
                 ->where('phieu_cham.maGV',Session::get('maGV_2'))
                 ->where('phieu_cham.isDelete',false);
             })
             ->get(['maPhieuCham','diemChu']);
        }
    
        $diemChu=[];
        $tiLe=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
            array_push($tiLe,$dethi->where('diemChu',$lt)->count()*100/$dethi->count());
        }
        return view('layouts.thongke.thongke_diemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter,'ct_baiQH'=>$ct_baiQH]);
    }
}
