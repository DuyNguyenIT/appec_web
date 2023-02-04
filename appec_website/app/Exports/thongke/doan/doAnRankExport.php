<?php

namespace App\Exports\thongke\doan;

use Session;
use App\Models\deThi;
use Illuminate\Contracts\View\View;
use App\Models\ct_bai_quy_hoach;
use Maatwebsite\Excel\Concerns\FromView;

class doAnRankExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $maCanBo=Session::get('maCanBo');

        //ct bai quy hoach
        $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->leftjoin('loai_ht_danhgia',function($x){
            $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('ct_bai_quy_hoach.isDelete',false);
        })->first();

        Session::put('maGV_2',$ct_baiQH->maGV_2);

        if($maCanBo==1){
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
            if($dethi->count()==0)
            {
                alert()->warning('There are no examination!','Message');
                return redirect()->back();
            } 
        }
        else{
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
            if($dethi->count()==0)
            {
                alert()->warning('There are no examination!','Message');
                return redirect()->back();
            } 
        }
       

        $xepHang=[];
        $tiLe=[];
        for ($i=1; $i <=5 ; $i++) { 
            array_push($xepHang,$dethi->where('xepHang',$i)->count());
            $rate=$dethi->where('xepHang',$i)->count()*100/$dethi->count('maPhieuCham');
            array_push($tiLe,$rate);
        }

        return view('layouts.thongke.thongke_xepHang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);
    }
}
