<?php

namespace App\Exports\thongke\tracnghiem;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\danhgia_tracnghiem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class tracnghiemSOExport implements FromView
{
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
         //check de thi
         $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();     
         $chuan_dau_ra3_array=[];
         $chuan_dau_ra3=[];
         $i=0;
         //tach tieu chi da duoc  su dung
         foreach($ds_de_thi as $dt){      
             //de_thi->de_thi_cauhoi-->cau_hoi
             //              |____________>phuong_an_tu_luan-->cdr_cd3
             $cdr3=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maDe',$dt->maDe)
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('de_thi_cau_hoi',function($x){
                 $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
             })
             ->join('phuong_an_trac_nghiem',function($x){
                 $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
             })
             ->join('cdr_cd3',function($x){
                 $x->on('cdr_cd3.maCDR3','=','phuong_an_trac_nghiem.maCDR3');
             })
             ->orderBy('cdr_cd3.maCDR3')
             ->get('cdr_cd3.maCDR3');
            
             //tach maCDR3 tu nhieu de thi thanh 1 mang
             foreach ($cdr3 as $value) {
                 if(!in_array($value['maCDR3'],$chuan_dau_ra3_array)){
                    $chuan_dau_ra3_array[$i]=$value['maCDR3'];
                    $i++;
                 }
             }
         }
         
         $chuan_dau_ra3=CDR3::whereIn('maCDR3',$chuan_dau_ra3_array)->get();
        
         //phieuCham
         $phieuCham=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',Session::get('maGV'))
             ->where('phieu_cham.isDelete',false);
         })
         ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
        
         //duyet qua tieu chi
         $bieuDo=[];
         foreach ($chuan_dau_ra3 as $cdr3) {
             
             $temp=[];
             //lay noi dung cdr3
             array_push($temp,$cdr3->maCDR3VB);
             array_push($temp,$cdr3->tenCDR3);
             //bien dem
             $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
             //duyet qua phieu cham
             foreach ($phieuCham as $pc) {
                 $t=$cdr3->maCDR3;
                  //dethi
                 $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                 
                 //dethi->phuongAn
                 $phuongan=deThi::where('de_thi.isDelete',false)
                 ->where('de_thi.maDe',$dethi->maDe)
                 ->where('maCTBaiQH',$maCTBaiQH)
                 ->join('de_thi_cau_hoi',function($x){
                    $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                 })
                 ->join('phuong_an_trac_nghiem',function($x){
                     $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                 })
                 ->distinct(['de_thi.maDe','de_thi_cau_hoi.maCauHoi'])
                 ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maCDR3']);
                 
                 ////tinh diem tieu chi cua phieu cham
                 ////phuongan->diem_tieu_chi
                 $diem_tieu_chi=$phuongan->where('maCDR3',$cdr3->maCDR3)->sum('diem');
               
                 // tinh diem sinh vien dat duoc tren tieu chi
                 //điếm theo phiếu chấm
                 $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                 ->join('phuong_an_trac_nghiem',function($x) use ($t){
                     $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                     ->where('phuong_an_trac_nghiem.maCDR3',$t);
                 })
                 ->sum('danhgia_tracnghiem.diem');
                 
                 /// tinnh ti le
                 $tile=number_format($dem/$diem_tieu_chi,2);
 
                 if($tile<0.4){
                     $cdat++;
                 }else{
                     if($tile>=0.4 && $tile<0.54){
                         $dat_D++;
                     }else{
                         if($tile>=0.55 && $tile<0.69){
                             $dat_C++;
                         }else{
                             if($tile>=0.70 && $tile<0.89){
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
             array_push($bieuDo,$temp);
         }
 
         return view('layouts.thongke.thong_ke_so',compact('bieuDo'));
    }
}
