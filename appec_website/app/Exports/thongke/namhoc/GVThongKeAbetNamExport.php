<?php

namespace App\Exports\thongke\namhoc;

use Session;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\chuan_abet;
use App\Models\ct_bai_quy_hoach;
use App\Models\thongke_abet_hocphan;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class GVThongKeAbetNamExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $namHoc=Session::get('namHoc');
        ///danh sach so
        $chuanAbet=chuan_abet::all();
        $arr_thongkeKQ=[];

        //lay ds giang day > theo nam
        $ds_giangday=giangDay::where('isDelete',false)->where('namHoc',$namHoc)->where('maGV',Session::get('maGV'))
        ->distinct(['maHK','namHoc'])->orderBy('id','desc')->get();
        
        //lay danh sach ma hoc phan > theo nam
        $ds_maHocPhan=giangDay::where('isDelete',false)->where('namHoc',$namHoc)->where('maGV',Session::get('maGV'))
        ->distinct(['maHK','namHoc'])->pluck('maHocPhan');

        //duyet qua giang day
        foreach ($ds_giangday as  $gd) {
            $temp=[];
            //maBaiQH-> list maCTBaiQH
            $arr_maCTBaiQH=ct_bai_quy_hoach::where('maBaiQH',$gd->maBaiQH)->orderBy('maCTBaiQH')->get();
            
            //neu chi tiet bai quy hoach khac null thi chay tiep
            if($arr_maCTBaiQH){
                array_push($temp,$gd->namHoc);
                array_push($temp,$gd->maHK);
                array_push($temp,$gd->maLop);
                array_push($temp,$gd->maHocPhan);
                //duyet qua cac chuan abet;
                foreach ($chuanAbet as  $abet) {
                    $ketqua=0;
                    //luu lai thong tin cua cac lan danh gia de tinh toan
                    $solandanhgia=0; //bien dem so lan danh gia cua muc abet tren ca ban lan qua trinh 1,2 và ket thuc
                    foreach ($arr_maCTBaiQH as $ct) {
                        $thongke_abet_hocphan=thongke_abet_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->get();
                        if(count($thongke_abet_hocphan)>0){
                            $solandanhgia++;
                        }
                    }

                    //duyet qua cac chi tiet bai quy hoach de tinh ket qua theo chuan abet
                    foreach ($arr_maCTBaiQH as $ct) {
                        $thongke_abet_hocphan=thongke_abet_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->get();
                        
                        if(count($thongke_abet_hocphan)==1){   // neu chi co 1 record (truong hop diem qua trinh hoac ket thuc mon 1 nguoi cham)
                           
                            $tong=1;
                            //tong sinh vien
                            $tong= $thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                            
                            //ti le lan 1 dat chuan abet
                            if($tong!=0){
                                if($solandanhgia==1){
                                    $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong);
                                }else{
                                    if($solandanhgia==2){
                                        $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*(0.5);
                                    }else{
                                        if($solandanhgia==3){
                                            $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*($ct->trongSo/100);
                                        }
                                    }
                                }
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
                                    if($solandanhgia==1){
                                        $ketqua= $ketqua + $tile;
                                    }else{
                                        
                                        if($solandanhgia==2){
                                            $ketqua= $ketqua + $tile*0.5;
                                           
                                        }else{
                                            if($solandanhgia==3){
                                                $ketqua= $ketqua + $tile * ($ct->trongSo/100);
                                            }
                                        }
                                    }
                                }else{
                                    $ketqua= $ketqua + $tile;
                                }
                               
                                
                            }else{  ///chua co diem hoac chua thong ke

                            }
                        }
                        
                    }  ///-----> het dong for
                  
                   
                    //luu lai du lieu
                    array_push($temp,$ketqua);
                     
                }
            }
            
            array_push($arr_thongkeKQ,$temp);
        }
        $hocPhan=hocPhan::whereIn('maHocPhan',$ds_maHocPhan)->get();
        return view('giangvien.thongkeketquatheonam.abet.view_export_abet_nam',\compact('chuanAbet','arr_thongkeKQ','hocPhan'));
    }
}