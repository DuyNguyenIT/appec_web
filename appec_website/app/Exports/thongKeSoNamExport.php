<?php

namespace App\Exports;
use Session;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\CDR3;
use App\Models\ct_bai_quy_hoach;
use App\Models\hocPhan_ctDaoTao;
use Illuminate\Contracts\View\View;
use App\Models\thongke_so_hocphan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class thongKeSoNamExport implements FromView
{
    /**
    * thống kê SOs theo năm học
    */
    public function view(): View
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
      
        ///danh sach so
        $CDR3=CDR3::orderBy('maCDR3VB')->get();
        $arr_thongkeKQ=[];
        //danh sach hoc phan theo chuong trinh dao tao
        $ds_hp_ctdt=hocPhan_ctDaoTao::where('maCT',$maCT)->pluck('maHocPhan');
        //lay ds giang day
        $ds_giangday=giangDay::where('namHoc',$namHoc)->whereIn('maHocPhan',$ds_hp_ctdt)->get();
        //lay danh sach ma hoc phan
        $ds_maHocPhan=giangDay::where('namHoc',$namHoc)->whereIn('maHocPhan',$ds_hp_ctdt)->pluck('maHocPhan');

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
                foreach ($CDR3 as  $cdr3) {
                    $ketqua=0;
                    $solandanhgia=0;
                    foreach ($arr_maCTBaiQH as $ct) {
                        $thongke_so_hocphan=thongke_so_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maCDR3',$cdr3->maCDR3)->get();
                        if(count($thongke_so_hocphan)>0){
                            $solandanhgia++;
                        }
                    }
                    //duyet qua cac chi tiet bai quy hoach de tinh ket qua theo chuan abet
                    foreach ($arr_maCTBaiQH as $ct) {
                        $thongke_so_hocphan=thongke_so_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maCDR3',$cdr3->maCDR3)->get();
                        if(count($thongke_so_hocphan)==1){   // neu chi co 1 record (truong hop diem qua trinh hoac ket thuc mon 1 nguoi cham)
                           
                            $tong=1;
                            //tong sinh vien
                            $tong= $thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B+$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D+$thongke_so_hocphan[0]->chua_dat;
                            
                            //ti le lan 1 dat chuan abet
                            if($tong!=0){
                                if ($solandanhgia==1) {
                                    # code...
                                    $ketqua=$ketqua+(($thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B +$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D)/$tong);

                                } else {
                                    # code...
                                    if ($solandanhgia==2) {
                                        # code...
                                        $ketqua=$ketqua+(($thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B +$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D)/$tong)*(0.5);

                                    } else {
                                        # code...
                                        if ($solandanhgia==3) {
                                            # code...
                                            $ketqua=$ketqua+(($thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B +$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D)/$tong)*($ct->trongSo/100);
                                        } 
                                    }
                                }
                                
                            }

                        }else{
                            if(count($thongke_so_hocphan)==2){   //neu co 2 records (cuoi ki co 2 nguoi cham) 
                              
                                $tong=1;
                                $tile=0;
                               
                                //tong sinh vien
                                $tong= $thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B+$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D+$thongke_so_hocphan[0]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B +$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D)/$tong)*0.5;

                                }
                                
                                $tong= $thongke_so_hocphan[1]->dat_A+$thongke_so_hocphan[1]->dat_B+$thongke_so_hocphan[1]->dat_C+$thongke_so_hocphan[1]->dat_D+$thongke_so_hocphan[1]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_so_hocphan[1]->dat_A+$thongke_so_hocphan[1]->dat_B +$thongke_so_hocphan[1]->dat_C+$thongke_so_hocphan[1]->dat_D)/$tong)*0.5;

                                }
                
                                if($ketqua!=0){
                                    if($solandanhgia==1){
                                        $ketqua= $ketqua + $tile;
                                    }else{
                                        if($solandanhgia==1){
                                            $ketqua= $ketqua + $tile * (0.5);
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
                    }
                    array_push($temp,$ketqua);
                }
            }
            array_push($arr_thongkeKQ,$temp);
        }
        $hocPhan=hocPhan::whereIn('maHocPhan',$ds_maHocPhan)->get();
        return view('admin.thongkeketquatheonam.so.view_export_so_nam',\compact('CDR3','arr_thongkeKQ','hocPhan'));


    }
}
