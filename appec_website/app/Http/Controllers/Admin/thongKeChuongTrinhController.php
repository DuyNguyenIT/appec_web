<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\CDR3;
use App\Models\hocPhan;
use App\Models\ctDaoTao;
use App\Models\giangDay;
use App\Models\chuan_abet;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\ct_bai_quy_hoach;
use App\Models\hocPhan_ctDaoTao;
use App\Models\thongke_so_hocphan;
use App\Http\Controllers\Controller;
use App\Models\thongke_abet_hocphan;
use App\Exports\thongKeAbetNamExport;
use App\Exports\thongKeSoNamExport;
use App\Exports\thongKeSoNamGrandedExport;
use App\Exports\thongKeAbetNamGrandedExport;
use App\Exports\thongKeSOHocKiExport;
use App\Exports\thongKeAbetHocKiExport;

class thongKeChuongTrinhController extends Controller
{
    public function index(Type $var = null)
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->get();
        return view('admin.thongkeketquatheohocki.chuongtrinh',['ctdaotao'=>$ctdt]);
    }

    public function chon_thoi_gian($maCT)
    {
        Session::put('maCT',$maCT);
        $ctDaoTao=ctDaoTao::find($maCT);
        $ds_maHocPhan=hocPhan_ctDaoTao::where('maCT',$maCT)->pluck('maHocPhan');

        $gd=giangDay::where('giangday.isDelete',false)
        ->whereIn('maHocPhan',$ds_maHocPhan)
        ->orderBy('giangday.namHoc','desc')
        ->distinct(['namHoc'])->get('namHoc'); //dung bien nay hien thi len table
        
        $gd_full=giangDay::where('giangday.isDelete',false)
        ->whereIn('maHocPhan',$ds_maHocPhan)->get();  //dung bien nay de diem mon hoc

        return view('admin.thongkeketquatheohocki.chon_thoi_gian',compact('ctDaoTao','gd','gd_full'));
    }

    public function chon_lop($maHK,$namHoc)
    {
        Session::put('maHK',$maHK);
        Session::put('namHoc',$namHoc);
        $ctDaoTao=ctDaoTao::find(Session::get('maCT'));
        $ds_maHocPhan=hocPhan_ctDaoTao::where('maCT',Session::get('maCT'))->pluck('maHocPhan');
        $gd=giangDay::where('giangday.isDelete',false)
        ->whereIn('maHocPhan',$ds_maHocPhan)
        ->where('namHoc',$namHoc)
        ->where('maHK',$maHK)
        ->distinct(['maLop'])
        ->orderBy('maLop','desc')
        ->get('maLop'); //dung bien nay hien thi len table

        return view('admin.thongkeketquatheohocki.chon_lop',\compact('ctDaoTao','gd'));
    }

    public function thong_ke_theo_abet($maLop)
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
        Session::put('maLop',$maLop);
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

        // return $ds_giangday;
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
        //dd( $arr_thongkeKQ);
        $ctdaotao=ctDaoTao::where('maCT', session::get('maCT'))->first();
        return view('admin.thongkeketquatheohocki.abet.index',\compact('ctdaotao','chuanAbet','arr_thongkeKQ','hocPhan'));
    }

    public function export_excel_abet_hoc_ki(Excel $excel,$maLop)
    {
        Session::put('maLop',$maLop);
        return $excel->download(new thongKeAbetHocKiExport,'bang_thong_ke_abet_'.$maLop.'_'.Session::get('maHK').'_'.Session::get('namHoc').'.xlsx');
    }

    public function thong_ke_theo_so($maLop)
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
        Session::put('maLop',$maLop);
        ///danh sach so
        $CDR3=CDR3::orderBy('maCDR3VB')->get();
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
        //dd( $arr_thongkeKQ);
        $ctdaotao=ctDaoTao::where('maCT', session::get('maCT'))->first();

        return view('admin.thongkeketquatheohocki.so.index',\compact('ctdaotao','CDR3','arr_thongkeKQ','hocPhan'));
    }

    public function export_excel_so_hoc_ki(Excel $excel,$maLop)
    {
        Session::put('maLop',$maLop);
        return $excel->download(new thongKeSOHocKiExport,'bang_thong_ke_so_'.$maLop.'_'.Session::get('maHK').'_'.Session::get('namHoc').'.xlsx');
    }

    public function thong_ke_theo_clo($maLop)
    {
        $maCT=Session::get('maCT');
        $maHK=Session::get('maHK');
        $namHoc=Session::get('namHoc');
        Session::put('maLop',$maLop);
        ///danh sach clo
        
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
    }


    // -------------thong ke theo nam----------
    public function thong_ke_abet_theo_nam(Excel $excel,$namHoc)
    {
        Session::put('namHoc',$namHoc);
        return $excel->download(new thongKeAbetNamExport,'bang_thong_ke_abet_'.$namHoc.'.xlsx');
    }

    public function thong_ke_abet_theo_nam_granded(Excel $excel,$namHoc)
    {
        Session::put('namHoc',$namHoc);
        return $excel->download(new thongKeAbetNamGrandedExport,'bang_thong_ke_abet_'.$namHoc.'_xep_hang.xlsx');
    }

    public function thong_ke_so_theo_nam(Excel $excel,$namHoc)
    {
        Session::put('namHoc',$namHoc);
        return $excel->download(new thongKeSoNamExport,'bang_thong_ke_so_'.$namHoc.'.xlsx');
    }

    public function thong_ke_so_theo_nam_granded(Excel $excel,$namHoc)
    {
        Session::put('namHoc',$namHoc);
        return $excel->download(new thongKeSoNamGrandedExport,'bang_thong_ke_so_'.$namHoc.'_xep_hang.xlsx');
    }
}
