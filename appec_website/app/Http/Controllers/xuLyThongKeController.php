<?php

namespace App\Http\Controllers;

use session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\chuan_abet;
use Illuminate\Http\Request;
use App\Models\danhgia_tuluan;

class xuLyThongKeController extends Controller
{
     //tao cac ham thong ke dung chung giua giao vu va giang vien
    
    //ham tra ve so lieu thong ke diem phieu cham theo tieu chi CDR3
    public static function thong_ke_CDR3($maCTBaiQH)
    {
        $chuan_dau_ra3=[];
        $chuan_dau_ra3_array=[];
        $phuongan=[];
        //duyet dethi
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        //tach lay CDR3 trong de thi
        $i=0;
        foreach($ds_de_thi as $dt){
            //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $cdr3=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cauhoi_tuluan',function($x){
                $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_tu_luan',function($x){
                $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
            })
            ->join('cdr_cd3',function($x){
                $x->on('cdr_cd3.maCDR3','=','phuong_an_tu_luan.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->distinct(['cdr_cd3.maCDR3','cdr_cd3.tenCDR3'])
            ->orderBy('cdr_cd3.maCDR3')
            ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($cdr3 as $value) {
                if(!in_array($value['maCDR3'],$chuan_dau_ra3_array)){
                   $chuan_dau_ra3_array[$i]=$value['maCDR3'];
                   $i++;
                }
            }
        }
        //lay noi dung cdr3
        $chuan_dau_ra3=CDR3::where('isDelete',false)->whereIn('maCDR3',$chuan_dau_ra3_array)->get();
        //lay tat ca phieu cham thuoc de_thi
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
        //bien du lieu thong ke
        $data=[];
        //duyet qua tat ca chuan dau ra
        foreach ($chuan_dau_ra3 as $cdr3) {

            $temp=[];
            //lay noi dung cdr3
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;

            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cauhoi_tuluan',function($x){
                    $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_tu_luan',function($x){
                   $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
               })
               ->get(['phuong_an_tu_luan.id','phuong_an_tu_luan.noiDungPA','phuong_an_tu_luan.diemPA','phuong_an_tu_luan.maCDR3']);
               //phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maCDR3',$cdr3->maCDR3)->sum('diemPA');

                //điếm theo phiếu chấm
                $dem=danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_tu_luan',function($x) use ($t){
                    $x->on('phuong_an_tu_luan.id','=','danhgia_tuluan.maPATL')
                    ->where('phuong_an_tu_luan.maCDR3',$t);
                })
                ->sum('danhgia_tuluan.diemDG');
               

                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.25){
                    $cdat++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $dat_D++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $dat_C++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }

            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($data,$temp);
        }

        return $data;
    }

    //ham tra ve so lieu thong ke phieu cham theo chuan abet
    public static function thong_ke_abet($maCTBaiQH)
    {
        $chuan_abet=[];
        $chuan_abet_array=[];
        $phuongan=[];
        //duyet dethi
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
       
        //tach lay abet trong de thi
        $i=0;
        foreach($ds_de_thi as $dt){
            //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $chuan_abet=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cauhoi_tuluan',function($x){
                $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_tu_luan',function($x){
                $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
            })
            ->join('chuan_abet',function($x){
                $x->on('chuan_abet.maChuanAbet','=','phuong_an_tu_luan.maChuanAbet')
                ->where('chuan_abet.isDelete',false);
            })
            ->distinct(['chuan_abet.maChuanAbet','chuan_abet.tenChuanAbet'])
            ->orderBy('chuan_abet.maChuanAbet')
            ->get(['chuan_abet.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet']);

            //tach ma abet tu nhieu de thi thanh 1 mang
            foreach ($chuan_abet as $value) {
                if(!in_array($value['maChuanAbet'],$chuan_abet_array)){
                   $chuan_abet_array[$i]=$value['maChuanAbet'];
                   $i++;
                }
            }

        }
         //lay noi dung abet
        $chuan_abet=chuan_abet::where('isDelete',false)->whereIn('maChuanAbet',$chuan_abet_array)->get();
        
        
        //lay tat ca phieu cham thuoc de_thi
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

        //bien du lieu thong ke
        $data=[];
        foreach ($chuan_abet as $abet) {
            $temp=[];
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
                //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cauhoi_tuluan',function($x){
                    $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_tu_luan',function($x){
                    $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
                })
                ->get(['phuong_an_tu_luan.id','phuong_an_tu_luan.noiDungPA','phuong_an_tu_luan.diemPA','phuong_an_tu_luan.maChuanAbet']);
               
               //phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maChuanAbet',$abet->maChuanAbet)->sum('diemPA');

                //điếm theo phiếu chấm
                $dem=danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_tu_luan',function($x) use ($t){
                    $x->on('phuong_an_tu_luan.id','=','danhgia_tuluan.maPATL')
                    ->where('phuong_an_tu_luan.maChuanAbet',$t);
                })
                ->sum('danhgia_tuluan.diemDG');
               

                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.25){
                    $cdat++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $dat_D++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $dat_C++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }
            
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($data,$temp);
        }
        return $data;

    }

    public function thong_ke_kqht($maCTBaiQH)
    {
        $ket_qua_ht=[];
        $kqht_array=[];
        $phuongan=[];
        //duyet dethi
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
          //tach lay abet trong de thi
          $i=0;
        foreach($ds_de_thi as $dt){
            //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $kqht=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe) 
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cauhoi_tuluan',function($x){
                $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
            })
            ->join('cau_hoi',function($y){
                $y->on('de_thi_cauhoi_tuluan.maCauHoi','=','cau_hoi.maCauHoi');
            })
            ->get(['cau_hoi.maKQHT']);

            //tach ma kqht tu nhieu de thi thanh 1 mang
            foreach ($kqht as $value) {
                if(!in_array($value['maKQHT'],$kqht_array)){
                    $kqht_array[$i]=$value['maKQHT'];
                    $i++;
                }
            }
        }
        $ket_qua_ht=kqHTHP::whereIn('maKQHT',$kqht_array)->get();
        //lay tat ca phieu cham thuoc de_thi
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

    }

    //tra ve so lieu thong ke xep hang
    public static function thong_ke_xep_hang($maCTBaiQH,$maGV)
    {
        $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x)use($maGV){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',$maGV)
             ->where('phieu_cham.isDelete',false);
         })
         ->get(['maPhieuCham','xepHang']);
         //xếp hạng
        $xepHang=[];
        for ($i=1; $i <=5 ; $i++) { 
            array_push($xepHang,$dethi->where('xepHang',$i)->count());
        }
        return $xepHang;
    }

    public static  function thong_ke_ti_le_xep_hang($maCTBaiQH,$maGV)
    {
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x) use($maGV){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',$maGV)
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','xepHang']);
       //ti le
       $tiLe=[];
       for ($i=1; $i <=5 ; $i++) { 
           $rate=number_format($dethi->where('xepHang',$i)->count()*100/$dethi->count('maPhieuCham'),2);
           array_push($tiLe,$rate);
       }
       return $tiLe;
    }

    //tra ve so lieu thong ke diem chu
    public static function thong_ke_diem_chu($maCTBaiQH,$maGV)
    {
        //đề thi
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x)use ($maGV){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',$maGV)
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
        $diemChu=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
        }
        return $diemChu;
    }

    public static function thong_le_ti_le_diem_chu($maCTBaiQH,$maGV)
    {
        //đề thi
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x)use ($maGV){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',$maGV)
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
        $tiLe=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($tiLe,number_format($dethi->where('diemChu',$lt)->count()*100/$dethi->count(),2));
        }
        return $diemChu;
    }
}
