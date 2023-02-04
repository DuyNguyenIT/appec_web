<?php

namespace App\Exports\thongke\tracnghiem;
use Session;
use App\Models\deThi;
use App\Models\chuan_abet;
use App\Models\danhgia_tracnghiem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class tracnghiemAbetExport implements FromView
{
  
    public function view(): View
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        //check de thi
        $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();

        $chuan_abet_array=[];
        $chuan_abet=[];
        $i=0;

        //tach tieu chi da duoc  su dung
        foreach($ds_de_thi as $dt){      
            //de_thi->de_thi_cauhoi-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $abet=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cau_hoi',function($x){
                $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_trac_nghiem',function($x){
                $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
            })
            ->join('chuan_abet',function($x){
                $x->on('chuan_abet.maChuanAbet','=','phuong_an_trac_nghiem.maChuanAbet');
            })
            ->orderBy('chuan_abet.maChuanAbet')
            ->get('chuan_abet.maChuanAbet');
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($abet as $value) {
                if(!in_array($value['maChuanAbet'],$chuan_abet_array)){
                   $chuan_abet_array[$i]=$value['maChuanAbet'];
                   $i++;
                }
            }
        }
        
        $chuan_abet=chuan_abet::whereIn('maChuanAbet',$chuan_abet_array)->orderBy('maChuanAbetVB')->get();
       
       
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
        foreach ($chuan_abet as $abet) {
            
            $temp=[];
            //lay noi dung abet
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            //duyet qua phieu cham
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
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
                ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maChuanAbet']);
               
                ////tinh diem tieu chi cua phieu cham
                ////phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maChuanAbet',$abet->maChuanAbet)->sum('diem');
                
                // tinh diem sinh vien dat duoc tren tieu chi
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x) use ($t){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                    ->where('phuong_an_trac_nghiem.maChuanAbet',$t);
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
        return view('layouts.thongke.thongke_abet',compact('bieuDo'));
    }
}
