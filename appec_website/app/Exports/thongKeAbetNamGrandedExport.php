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

class thongKeAbetNamGrandedExport implements FromView
{
    // controller nay thong ke abet co phan theo cap do dat A, B, C D
    public function view(): View
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
        ///danh sach so
        $chuanAbet=chuan_abet::all();
        $arr_thongkeKQ=[];
        //danh sach hoc phan theo chuong trinh dao tao
        $ds_hp_ctdt=hocPhan_ctDaoTao::where('maCT',$maCT)->pluck('maHocPhan');
        //lay ds giang day > theo nam
        $ds_giangday=giangDay::where('namHoc',$namHoc)->whereIn('maHocPhan',$ds_hp_ctdt)->get();
        
        //lay danh sach ma hoc phan > theo nam
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
                foreach ($chuanAbet as  $abet) {
                    $ketqua=0;
                    $A=$B=$C=$D=$fail=0;
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
                                    $A=$A+($thongke_abet_hocphan[0]->dat_A/$tong);
                                    $B=$B+($thongke_abet_hocphan[0]->dat_B/$tong);
                                    $C=$C+($thongke_abet_hocphan[0]->dat_C/$tong);
                                    $D=$D+($thongke_abet_hocphan[0]->dat_D/$tong);
                                    $fail=$fail+($thongke_abet_hocphan[0]->chua_dat/$tong);
                                }else{
                                    if($solandanhgia==2){
                                        $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*(0.5);
                                        $A=$A+($thongke_abet_hocphan[0]->dat_A/$tong)*(0.5);
                                        $B=$B+($thongke_abet_hocphan[0]->dat_B/$tong)*(0.5);
                                        $C=$C+($thongke_abet_hocphan[0]->dat_C/$tong)*(0.5);
                                        $D=$D+($thongke_abet_hocphan[0]->dat_D/$tong)*(0.5);
                                        $fail=$fail+($thongke_abet_hocphan[0]->chua_dat/$tong)*(0.5);
                                    }else{
                                        if($solandanhgia==3){
                                            $ketqua=$ketqua+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*($ct->trongSo/100);
                                            $A=$A+($thongke_abet_hocphan[0]->dat_A/$tong)*($ct->trongSo/100);
                                            $B=$B+($thongke_abet_hocphan[0]->dat_B/$tong)*($ct->trongSo/100);
                                            $C=$C+($thongke_abet_hocphan[0]->dat_C/$tong)*($ct->trongSo/100);
                                            $D=$D+($thongke_abet_hocphan[0]->dat_D/$tong)*($ct->trongSo/100);
                                            $fail=$fail+($thongke_abet_hocphan[0]->chua_dat/$tong)*($ct->trongSo/100);
                                        }
                                    }
                                }
                            }
                           
                        }else{
                            if(count($thongke_abet_hocphan)==2){   //neu co 2 records (cuoi ki co 2 nguoi cham) 
                              
                                $tong=1;
                                $tile=0;
                                $tile_A=$tile_B=$tile_C=$tile_D=$tile_fail=0;
                                //tong sinh vien
                                $tong= $thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B +$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D)/$tong)*0.5;
                                    $tile_A=$tile_A+($thongke_abet_hocphan[0]->dat_A/$tong)*0.5;
                                    $tile_B=$tile_B+($thongke_abet_hocphan[0]->dat_B/$tong)*0.5;
                                    $tile_C=$tile_C+($thongke_abet_hocphan[0]->dat_C/$tong)*0.5;
                                    $tile_D=$tile_D+($thongke_abet_hocphan[0]->dat_D/$tong)*0.5;
                                    $tile_fail=$tile_fail+($thongke_abet_hocphan[0]->chua_dat/$tong)*0.5;
                                }
                                
                                $tong= $thongke_abet_hocphan[1]->dat_A+$thongke_abet_hocphan[1]->dat_B+$thongke_abet_hocphan[1]->dat_C+$thongke_abet_hocphan[1]->dat_D+$thongke_abet_hocphan[1]->chua_dat;
                                if($tong!=0){
                                    $tile=$tile+(($thongke_abet_hocphan[1]->dat_A+$thongke_abet_hocphan[1]->dat_B +$thongke_abet_hocphan[1]->dat_C+$thongke_abet_hocphan[1]->dat_D)/$tong)*0.5;
                                    $tile_A=$tile_A+($thongke_abet_hocphan[1]->dat_A/$tong)*0.5;
                                    $tile_B=$tile_B+($thongke_abet_hocphan[1]->dat_B/$tong)*0.5;
                                    $tile_C=$tile_C+($thongke_abet_hocphan[1]->dat_C/$tong)*0.5;
                                    $tile_D=$tile_D+($thongke_abet_hocphan[1]->dat_D/$tong)*0.5;
                                    $tile_fail=$tile_fail+($thongke_abet_hocphan[1]->chua_dat/$tong)*0.5;
                                }
                            
                                if($ketqua!=0){
                                    if($solandanhgia==1){
                                        $ketqua= $ketqua + $tile;
                                        $A=$A+$tile_A;
                                        $B=$B+$tile_B;
                                        $C=$C+$tile_C;
                                        $D=$D+$tile_D;
                                        $fail=$fail+$tile_fail;

                                    }else{
                                        
                                        if($solandanhgia==2){
                                            $ketqua= $ketqua + $tile*0.5;
                                            $A=$A+$tile_A*0.5;
                                            $B=$B+$tile_B*0.5;
                                            $C=$C+$tile_C*0.5;
                                            $D=$D+$tile_D*0.5;
                                            $fail=$fail+$tile_fail*0.5;
                                           
                                        }else{
                                            if($solandanhgia==3){
                                                $ketqua= $ketqua + $tile * ($ct->trongSo/100);
                                                $A=$A+$tile_A* ($ct->trongSo/100);
                                                $B=$B+$tile_B* ($ct->trongSo/100);
                                                $C=$C+$tile_C* ($ct->trongSo/100);
                                                $D=$D+$tile_D* ($ct->trongSo/100);
                                                $fail=$fail+$tile_fail* ($ct->trongSo/100);
                                            }
                                        }
                                    }
                                }else{
                                    $ketqua= $ketqua + $tile;
                                    $A=$A+$tile_A;
                                    $B=$B+$tile_B;
                                    $C=$C+$tile_C;
                                    $D=$D+$tile_D;
                                }
                               
                                
                            }else{  ///chua co diem hoac chua thong ke

                            }
                        }
                        
                    }  ///-----> het dong for
                  
                   
                    //luu lai du lieu
                    //array_push($temp,$ketqua);
                    array_push($temp,$A);
                    array_push($temp,$B);
                    array_push($temp,$C);
                    array_push($temp,$D);
                    array_push($temp,$fail);
                     
                }
            }
            
            array_push($arr_thongkeKQ,$temp);
        }
        $hocPhan=hocPhan::whereIn('maHocPhan',$ds_maHocPhan)->get();
        return view('admin.thongkeketquatheonam.abet.view_export_abet_nam_granded',\compact('chuanAbet','arr_thongkeKQ','hocPhan'));

    }
}
