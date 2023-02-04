<?php

namespace App\Exports\thongke\tracnghiem;
use Session;
use App\Models\deThi;
use App\Models\kqHTHP;
use App\Models\danhgia_tracnghiem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class tracnghiemCLOExport implements FromView
{
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $ket_qua_ht=[];
        $kqht_array=[];
        $phuongan=[];
        //ds_de_thi 
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
         //tach lay kqht trong de thi
         $i=0;
         foreach($ds_de_thi as $dt){
             //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
             //              |____________>phuong_an_tu_luan-->cdr_cd3
             $kqht=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maDe',$dt->maDe) 
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('de_thi_cau_hoi',function($x){
                 $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
             })
             ->join('cau_hoi',function($y){
                 $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
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
 
         //get thong tin kqht tu csdls
        $ket_qua_ht=kqHTHP::whereIn('maKQHT',$kqht_array)->orderBy('maKQHTVB')->get();
        
         //lay tat ca phieu cham thuoc de_this
         $phieuCham=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',Session::get('maGV'))
             ->where('phieu_cham.isDelete',false);
         })->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
        //bien du lieu thong ke
        $bieuDo=[];
      
        foreach ($ket_qua_ht as $kqht) {
            $temp=[];
            array_push($temp,$kqht->maKQHTVB);
            array_push($temp,$kqht->tenKQHT);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            
            foreach ($phieuCham as $pc) {
                $t=$kqht->maKQHT;
                //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                    $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('cau_hoi',function($y){
                   $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
                })
               ->get(['cau_hoi.maCauHoi','cau_hoi.maKQHT','de_thi_cau_hoi.diem']);
               
               //phuongan->diem_tieu_chi
               $diem_tieu_chi=$phuongan->where('maKQHT',$kqht->maKQHT)->sum('diem');
               
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',556)
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA');
                })
                ->join('de_thi_cau_hoi',function($y){
                    $y->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->join('cau_hoi',function($z) use($t){
                    $z->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi')
                    ->where('cau_hoi.maKQHT',9);
                 })
                 ->sum('danhgia_tracnghiem.diem');
                
                $dem=number_format($dem,2);

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
        return view('layouts.thongke.thongke_clo',compact('bieuDo'));
    }
}
