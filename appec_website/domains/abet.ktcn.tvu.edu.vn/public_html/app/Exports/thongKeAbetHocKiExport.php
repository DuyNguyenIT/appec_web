<?php

namespace App\Exports;
use Session;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\chuan_abet;
use App\Models\ct_bai_quy_hoach;
use App\Models\hocPhan_ctDaoTao;
use Illuminate\Contracts\View\View;
use App\Models\thongke_abet_hocphan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class thongKeAbetHocKiExport implements FromView
{
 
    public function view(): View
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
        $maLop=Session::get('maLop');
        ///danh sach chuan abet
        $chuanAbet=chuan_abet::all();
        $arr_thongkeKQ=[];
        //danh sach hoc phan theo chuong trinh dao tao
        $ds_hp_ctdt=hocPhan_ctDaoTao::where('maCT',$maCT)->pluck('maHocPhan');
        //lay ds giang day
        $ds_giangday=giangDay::where('maLop',$maLop)
        ->where('namHoc',$namHoc)
        ->where('maHK',$maHK)
        ->whereIn('maHocPhan',$ds_hp_ctdt)
        ->get();
        //lay danh sach ma hoc phan
        $ds_maHocPhan=giangDay::where('maLop',$maLop)
        ->where('namHoc',$namHoc)
        ->where('maHK',$maHK)
        ->whereIn('maHocPhan',$ds_hp_ctdt)
        ->pluck('maHocPhan');

        //duyet qua giang day
        foreach ($ds_giangday as  $gd) {
            $temp=[];
           
            //maBaiQH-> list maCTBaiQH
            $arr_maCTBaiQH=ct_bai_quy_hoach::where('maBaiQH',$gd->maBaiQH)->orderBy('maCTBaiQH')->get();
            //neu chi tiet bai quy hoach khac null thi chay tiep
            if($arr_maCTBaiQH){
                array_push($temp,$gd->maHocPhan);
                //duyet qua cac chuan abet;
                foreach ($chuanAbet as  $abet) {
                    $ketqua=0;
                    //duyet qua cac chi tiet bai quy hoach de tinh ket qua theo chuan abet
                    foreach ($arr_maCTBaiQH as $ct) {
                        $thongke_abet_hocphan=thongke_abet_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->get();
                        if(count($thongke_abet_hocphan)==1){   // neu chi co 1 record (truong hop diem qua trinh hoac ket thuc mon 1 nguoi cham)
                           
                            $tong=1;
                            //tong sinh vien
                            $tong= $thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                            
                            //ti le lan 1 dat chuan abet
                            if($tong!=0){
                                $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*($ct->trongSo/100);
                            }

                        }else{
                            if(count($thongke_abet_hocphan)==2){   //neu co 2 records (cuoi ki co 2 nguoi cham) 
                              
                                $tong=1;
                                $tile=0;
                               
                                //tong sinh vien
                                $tong= $thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*0.5;

                                }
                                
                                $tong= $thongke_abet_hocphan[1]->dat_A+$thongke_abet_hocphan[1]->dat_B+$thongke_abet_hocphan[1]->dat_C+$thongke_abet_hocphan[1]->dat_D+$thongke_abet_hocphan[1]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_abet_hocphan[1]->dat_A+$thongke_abet_hocphan[1]->dat_B +$thongke_abet_hocphan[1]->dat_C+$thongke_abet_hocphan[1]->dat_D)/$tong)*0.5;

                                }
                
                                if($ketqua!=0){
                                    $ketqua= $ketqua + $tile * ($ct->trongSo/100);
                                }else{
                                    $ketqua= $ketqua + $tile;
                                }
                                
                            }else{  ///chua co diem hoac chua thong ke

                            }
                        }
                    }
                    array_push($temp,$ketqua);
                }
            }
            array_push($arr_thongkeKQ,$temp);
        }
        $hocPhan=hocPhan::whereIn('maHocPhan',$ds_maHocPhan)->get();
       
        return view('admin.thongkeketquatheohocki.abet.view_export_abet_hk',\compact('chuanAbet','arr_thongkeKQ','hocPhan'));
    }
}
