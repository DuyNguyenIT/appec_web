<?php

namespace App\Exports\thongke\doan;

use  Session;
use App\Models\deThi;
use App\Models\danhGia;
use App\Models\noiDungQH;
use App\Models\ct_bai_quy_hoach;
use Illuminate\Contracts\View\View;
use App\Models\tieuChuanDanhGia;
use Maatwebsite\Excel\Concerns\FromView;

class doAnSOExport implements FromView
{

    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $maCanBo=Session::get('maCanBo');
        //lấy danh sách cdr3
        ////maCTBaiQH-->noiDungQH
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->get();
         //ct bai quy hoach
         $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->leftjoin('loai_ht_danhgia',function($x){
             $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
             ->where('ct_bai_quy_hoach.isDelete',false);
         })
         ->first();
        Session::put('maGV_2',$ct_baiQH->maGV_2);

        $chuan_dau_ra3=[];
        $tieuchi=[];
        foreach ($ndqh as $key => $x) {
            ////noiDungQh->(tieuchuan+tieuChi+cdr3)
            $temp=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })
            ->join('cdr_cd3',function($y){
                $y->on('cdr_cd3.maCDR3','=','tieu_chi_cham_diem.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->distinct(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3'])
            ->orderBy('cdr_cd3.maCDR3')
            ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
            
            $temp_tc=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })->get(['tieu_chi_cham_diem.maTCCD','tieu_chi_cham_diem.diemTCCD','tieu_chi_cham_diem.maCDR3']);
            foreach ($temp as $t) {
                array_push($chuan_dau_ra3,$t);
            }
            foreach ($temp_tc as $tc) {
                array_push($tieuchi,$tc);
            }
        }

        //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if($maCanBo==1){
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }else{
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }
        $bieuDo=[];
        foreach ($chuan_dau_ra3 as $cdr3) {
            $temp=[];
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);
           
            $gioi=0;
            $kha=0;
            $tb=0;
            $yeu=0;
            $kem=0;

            $diem_tieu_chi=0;
            foreach ($tieuchi as $tc) {
                if($tc->maCDR3==$cdr3->maCDR3){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                }
            }
        
            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                /////////
                //điếm theo phiếu chấm
                $dem=danhGia::where('danh_gia.isDelete',false)
                ->where('maPhieuCham',$pc->maPhieuCham)
                ->join('tieu_chi_cham_diem',function($x) use ($t){
                    $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                    ->where('tieu_chi_cham_diem.maCDR3',$t)
                    ->where('tieu_chi_cham_diem.isDelete',false);
                })
                ->sum('danh_gia.diemDG');
                $tile=$dem/$diem_tieu_chi;
                if($tile<0.4){
                    $kem++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $yeu++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $tb++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
                                $kha++;
                            }else{
                                $gioi++;
                            }
                        }
                    }
                }
            }


            array_push($temp,$gioi);
            array_push($temp,$kha);
            array_push($temp,$tb);
            array_push($temp,$yeu);
            array_push($temp,$kem);
            array_push($bieuDo,$temp);
        }
        

        return view('layouts.thongke.thong_ke_so',['bieuDo'=>$bieuDo]);
    }
}
