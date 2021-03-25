<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ctDaoTao;
use App\Models\hocPhan;
use App\Models\hocPhan_kqHTHP;
use App\Models\hocPhan_ctDaoTao;
use App\Models\ctDaoTao_CDR1;
use App\Models\CDR1;
use App\Models\CDR2;
use App\Models\CDR3;


class thongKeController extends Controller
{
    //
    public function index(Type $var = null)
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->get();
        
        return view('admin.thongke.thongke',['ctdaotao'=>$ctdt]);
    }
    //thống kê CDR cấp độ 3 theo từng chương trình
    public function thong_ke_CT_theo_CDR3($maCT)
    {
        Session::put('maCT',$maCT);
       
        $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',$maCT)->first();
        
        $ctdt_cdr=ctDaoTao_CDR1::where('ctdt_cdrcd1.isDelete',false) ->where('maCT',$maCT)
        ->join('cdr_cd1',function($x){
            $x->on('cdr_cd1.maCDR1','=','ctdt_cdrcd1.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->join('cdr_cd2',function($y){
            $y->on('cdr_cd2.maCDR1','=','cdr_cd1.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($z){
            $z->on('cdr_cd3.maCDR2','=','cdr_cd2.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get();

        $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('maCT',$maCT)
        ->join('hoc_phan',function($a){
            $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        }) 
        ->get();

        $hp_cdr3=[];
        foreach ($hp_ctdt as $chon) {
           $temp=hocPhan_KQHTHP::where('hocphan_kqht_hp.isDelete',false) ->where ('maHocPhan',$chon->maHocPhan)
           ->groupBy('hocphan_kqht_hp.maHocPhan', 'hocphan_kqht_hp.maCDR3')->distinct()
           ->get();
            foreach ($temp as $t) {
                array_push($hp_cdr3,$t);
            }
        }
        return view('admin.thongke.thongkechuongtrinhCDR3',['ctdt_cdr'=>$ctdt_cdr,'ctdt'=>$ctdt,'hp_ctdt'=>$hp_ctdt,'hp_cdr3'=>$hp_cdr3]);
    }

   //vẽ biểu đồ cdr3 cấp chương trình
    // public function get_CDR3_chuong_trinh()
    // {
    //     $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',$maCT)->first();
        
    //     $ctdt_cdr=ctDaoTao_CDR1::where('ctdt_cdrcd1.isDelete',false) ->where('maCT',$maCT)
    //     ->join('cdr_cd1',function($x){
    //         $x->on('cdr_cd1.maCDR1','=','ctdt_cdrcd1.maCDR1')
    //         ->where('cdr_cd1.isDelete',false);
    //     })
    //     ->join('cdr_cd2',function($y){
    //         $y->on('cdr_cd2.maCDR1','=','cdr_cd1.maCDR1')
    //         ->where('cdr_cd2.isDelete',false);
    //     })
    //     ->join('cdr_cd3',function($z){
    //         $z->on('cdr_cd3.maCDR2','=','cdr_cd2.maCDR2')
    //         ->where('cdr_cd3.isDelete',false);
    //     })
    //     ->get();

    //     $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('maCT',$maCT)
    //     ->join('hoc_phan',function($a){
    //         $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
    //         ->where('hoc_phan.isDelete',false);
    //     }) 
    //     ->get();

    //     $hp_cdr3=[];
    //     foreach ($hp_ctdt as $chon) {
    //        $temp=hocPhan_KQHTHP::where('hocphan_kqht_hp.isDelete',false) ->where ('maHocPhan',$chon->maHocPhan)
    //        ->groupBy('hocphan_kqht_hp.maHocPhan', 'hocphan_kqht_hp.maCDR3')->distinct()
    //        ->get();
    //         foreach ($temp as $t) {
    //             array_push($hp_cdr3,$t);
    //         }
    //     }
    //     $bieuDo=[];
        
    //     foreach ($chuan_dau_ra3 as $cdr3) {
    //         $temp=[];
    //         array_push($temp,$cdr3->maCDR3VB);
    //         array_push($temp,$cdr3->tenCDR3);

    //         $gioi=0;
    //         $kha=0;
    //         $tb=0;
    //         $yeu=0;
    //         $kem=0;

    //         foreach ($phieuCham as $pc) {
                
    //             $diem_tieu_chi=0;
    //             foreach ($tieuchi as $tc) {
    //                 if($tc->maCDR3==$cdr3->maCDR3 && $tc->maCTBaiQH==$pc->maCTBaiQH){
    //                     $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
    //                 }
    //             }

    //             $t=$cdr3->maCDR3;
    //             /////////
    //             //điếm theo phiếu chấm
    //             $dem=danhGia::where('danh_gia.isDelete',false)
    //             ->where('maPhieuCham',$pc->maPhieuCham)
    //             ->join('tieu_chi_cham_diem',function($x) use ($t){
    //                 $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
    //                 ->where('tieu_chi_cham_diem.maCDR3',$t)
    //                 ->where('tieu_chi_cham_diem.isDelete',false);
    //             })
    //             ->sum('danh_gia.diemDG');

    //             if($diem_tieu_chi==0){
    //                 continue;
    //             }

    //             $tile=$dem/$diem_tieu_chi;
               


    //             if($tile<0.25){
    //                 $kem++;
    //             }else{
    //                 if($tile>=0.25 && $tile<0.5){
    //                     $yeu++;
    //                 }else{
    //                     if($tile>=0.5 && $tile<0.75){
    //                         $tb++;
    //                     }else{
    //                         if($tile>=0.75 && $tile<1){
    //                             $kha++;
    //                         }else{
    //                             $gioi++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         array_push($temp,$gioi);
    //         array_push($temp,$kha);
    //         array_push($temp,$tb);
    //         array_push($temp,$yeu);
    //         array_push($temp,$kem);
    //         array_push($bieuDo,$temp);
    //     }

    //     return response()->json($bieuDo);
    // } 
}


