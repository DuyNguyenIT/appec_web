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
use App\Models\chuan_abet;
use App\Models\kqHTHP;


class thongKeController extends Controller
{
    //
    public function index()
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->get();
        
        return view('admin.thongke.thongke',['ctdaotao'=>$ctdt]);
    }
    //th&#7889;ng k� CDR c&#7845;p &#273;&#7897; 3 theo t&#7915;ng ch&#432;&#417;ng tr�nh
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

   //v&#7869; bi&#7875;u &#273;&#7891; cdr3 c&#7845;p ch&#432;&#417;ng tr�nh
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
    //             //&#273;i&#7871;m theo phi&#7871;u ch&#7845;m
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

    //th&#7889;ng k� c&#7845;p ch&#432;&#417;ng tr�nh t&#432;&#417;ng quan abet v� cdio
     public function thong_ke_CT_theo_CDR3_Abet($maCT)
     {
       
        Session::put('maCT',$maCT);
        
         $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',$maCT)->first();
         $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('maCT',$maCT)
         ->join('hoc_phan',function($a){
             $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
             ->where('hoc_phan.isDelete',false);
         }) 
         ->get();
        
           $hp_kqhthp=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
           ->join('cdr_cd3',function($a){
            $a->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
            })
            ->join('kqht_hp',function($b){
                $b->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
                ->where('kqht_hp.isDelete',false);
                })
           ->get();
            
         $chuan_abet=chuan_abet::where('isDelete',false)->get();
         
         return view('admin.thongke.thongkechuongtrinhCDR3Abet',['ctdt'=>$ctdt,'hp_ctdt'=>$hp_ctdt,'hp_kqhthp'=>$hp_kqhthp,'chuan_abet'=>$chuan_abet]);
     }

     //v&#7869; bi&#7875;u &#273;&#7891; abet c&#7845;p ch&#432;&#417;ng tr�nh
    public function get_Abet_chuong_trinh()
    {
       
        $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',Session::get('maCT'))->first();
        $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('hocphan_ctdaotao.maCT',Session::get('maCT'))
         ->join('hoc_phan',function($a){
             $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
             ->where('hoc_phan.isDelete',false);
         }) 
         ->get();
      
        $chuan_abet=chuan_abet::where('isDelete',false)->get();
        $temp=[];
        foreach($chuan_abet as $chuan){
            array_push($temp,$chuan->maChuanAbetVB);//n�y &#273;&#7875; l�m tr&#7909;c x
        }
        $bieuDo=[];
        $dem=[0,0,0,0,0,0];//kh&#7903;i t&#7841;o cho bi&#7871;n &#273;&#7871;m s&#7889; l&#432;&#7907;ng m�n &#273;&#7841;t c&#7911;a 6 chu&#7849;n abet

       
        foreach ($hp_ctdt as $hp) {
            for ($i=0; $i <count($chuan_abet) ; $i++) { 
                $dem[$i]+=hocPhan_kqHTHP::where ('hocphan_kqht_hp.isDelete',false)
                ->where ('hocphan_kqht_hp.maHocPhan',$hp->maHocPhan)
                ->join('chuan_abet',function($a){
                            $a->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
                            ->where('chuan_abet.isDelete',false);
                        }) 
                ->distinct(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maChuanAbet'])
                ->where('hocphan_kqht_hp.maChuanAbet',$chuan_abet[$i]->maChuanAbet)
                ->count();
            }
            
        }
        
        array_push($bieuDo,$temp); //bi&#7875;u &#273;&#7891; s&#7869; l� m&#7897;t m&#7843;ng 2 chi&#7873;u, ki&#7875;u a[[0],[1]] khi tri&#7875;n khai s&#7869; th�nh A[[i0,i1,i2,...,i5],[j0,j1,j2,...,j5]] 
        array_push($bieuDo,$dem); 
       // return $bieuDo;
        return response()->json($bieuDo);

    } 

}


