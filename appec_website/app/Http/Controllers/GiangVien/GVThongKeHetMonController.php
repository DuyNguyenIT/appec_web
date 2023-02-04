<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\chuan_abet;
use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Models\ct_bai_quy_hoach;
use App\Models\thongke_so_hocphan;
use App\Models\thongke_abet_hocphan;

use App\Http\Controllers\Controller;

class GVThongKeHetMonController extends Controller
{
    public function cdio($maBaiQH,$maHocPhan)
    {
        //lấy các lần đánh giá thông qua maBaiQH->ctBaiQH[]
        $ct_baiquyhoach=ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->get();
        # khai báo mảng thongke[] để lưu lại tỉ lệ đạt ở từng mức
        $thongke=[];
        # lấy tất cả các chuẩn cdio
        $cdio=CDR3::all();
        #duyệt qua 
        foreach($cdio as $cdr3){
            ## duyệt qua các tiêu chí các lần đánh giá
            $so_lan_danh_gia=0;
            $dat_A=$dat_B=$dat_C=$dat_D=0;
            $temp=[];
            foreach($ct_baiquyhoach as $ct){
                ### đếm tiêu chí được đánh giá mấy lần, chỉ tính tren giảng viên đang đang nhập (maCanBo=1)
                $tk=thongke_so_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maCDR3',$cdr3->maCDR3)->where('maCanBo',1)->get();
                if(count($tk)>0){
                    $so_lan_danh_gia+=count($tk);
                }
            }
            if($so_lan_danh_gia>0){
                array_push($temp,$cdr3->maCDR3VB);
                if(Session::get('language') && Session::get('language')=='en'){
                    array_push($temp,$cdr3->tenCDR3EN);
                }else{
                    array_push($temp,$cdr3->tenCDR3);
                }
            }
            foreach($ct_baiquyhoach as $ct){
                $thongke_so_hocphan=thongke_so_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maCDR3',$cdr3->maCDR3)->get();
                
                if(count($thongke_so_hocphan)==1){
                    
                    $tong=1;
                    $tong=$thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B+$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D+$thongke_so_hocphan[0]->chua_dat;
                    
                    if($tong!=0){
                        switch ($so_lan_danh_gia) {
                            case 1:
                                # code...
                                $dat_A=$dat_A+($thongke_so_hocphan[0]->dat_A)/$tong;
                                $dat_B+=($thongke_so_hocphan[0]->dat_B)/$tong;
                                $dat_C+=($thongke_so_hocphan[0]->dat_C)/$tong;
                                $dat_D+=($thongke_so_hocphan[0]->dat_D)/$tong;
                                break;
                            case 2:
                                $dat_A=$dat_A+($thongke_so_hocphan[0]->dat_A*0.5)/$tong;
                                $dat_B+=($thongke_so_hocphan[0]->dat_B*0.5)/$tong;
                                $dat_C+=($thongke_so_hocphan[0]->dat_C*0.5)/$tong;
                                $dat_D+=($thongke_so_hocphan[0]->dat_D*0.5)/$tong;
                                break;
                            case 3:
                                $dat_A=$dat_A+($thongke_so_hocphan[0]->dat_A)*($ct->trongSo/100)/$tong;
                                $dat_B+=($thongke_so_hocphan[0]->dat_B)*($ct->trongSo/100)/$tong;
                                $dat_C+=($thongke_so_hocphan[0]->dat_C)*($ct->trongSo/100)/$tong;
                                $dat_D+=($thongke_so_hocphan[0]->dat_D)*($ct->trongSo/100)/$tong;
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }else{
                    if(count($thongke_so_hocphan)==2){
                        $tong=1;
                        $tile_A=$tile_B=$tile_C=$tile_D=0;     
                        $tong= $thongke_so_hocphan[0]->dat_A+$thongke_so_hocphan[0]->dat_B+$thongke_so_hocphan[0]->dat_C+$thongke_so_hocphan[0]->dat_D+$thongke_so_hocphan[0]->chua_dat;
                        if($tong!=0){
                            $tile_A=$tile_A+(($thongke_so_hocphan[0]->dat_A)/$tong)*0.5;
                            $tile_B=$tile_B+(($thongke_so_hocphan[0]->dat_B)/$tong)*0.5;
                            $tile_C=$tile_C+(($thongke_so_hocphan[0]->dat_C)/$tong)*0.5;
                            $tile_D=$tile_D+(($thongke_so_hocphan[0]->dat_D)/$tong)*0.5;
                        }
                                    
                        $tong= $thongke_so_hocphan[1]->dat_A+$thongke_so_hocphan[1]->dat_B+$thongke_so_hocphan[1]->dat_C+$thongke_so_hocphan[1]->dat_D+$thongke_so_hocphan[1]->chua_dat;
                        if($tong!=0){
                            $tile_A=$tile_A+(($thongke_so_hocphan[1]->dat_A)/$tong)*0.5;
                            $tile_B=$tile_B+(($thongke_so_hocphan[1]->dat_B)/$tong)*0.5;
                            $tile_C=$tile_C+(($thongke_so_hocphan[1]->dat_C)/$tong)*0.5;
                            $tile_D=$tile_D+(($thongke_so_hocphan[1]->dat_D)/$tong)*0.5;
                        }

                        if($dat_A!=0 || $dat_B!=0 || $dat_C!=0 || $dat_D!=0){
                            switch ($so_lan_danh_gia) {
                                case 1:
                                    # code...
                                    $dat_A=$dat_A+$tile_A;
                                    $dat_B+=$tile_B;
                                    $dat_C+=$tile_C;
                                    $dat_D+=$tile_D;
                                    break;
                                case 2:
                                    $dat_A=$dat_A+$tile_A*0.5;
                                    $dat_B+=$tile_B*0.5;
                                    $dat_C+=$tile_C*0.5;
                                    $dat_D+=$tile_D*0.5;
                                    break;
                                case 3:
                                    $dat_A=$dat_A+$tile_A*($ct->trongSo/100);
                                    $dat_B+=$tile_B*($ct->trongSo/100);
                                    $dat_C+=$tile_C*($ct->trongSo/100);
                                    $dat_D+=$tile_D*($ct->trongSo/100);
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }else{
                            $dat_A=$dat_A+$tile_A;
                            $dat_B+=$tile_B;
                            $dat_C+=$tile_C;
                            $dat_D+=$tile_D;
                        }
                    }
                }
            }
            if($so_lan_danh_gia>0){
                array_push($temp,number_format($dat_A*100,2));
                array_push($temp,number_format($dat_B*100,2));
                array_push($temp,number_format($dat_C*100,2));
                array_push($temp,number_format($dat_D*100,2));
                array_push($thongke,$temp); 
            }
        }
        # trả về kết quả cuối cùng
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        return view('giangvien.thongketheotungmon.so.view_so_tung_mon',['bieuDo'=>$thongke,'hocPhan'=>$hocPhan]);
    }


    public function abet($maBaiQH,$maHocPhan)
    {
        //lấy các lần đánh giá thông qua maBaiQH->ctBaiQH[]
        $ct_baiquyhoach=ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->get();
        # khai báo mảng thongke[] để lưu lại tỉ lệ đạt ở từng mức
        $thongke=[];
        # lấy tất cả các chuẩn cdio
        $abet=chuan_abet::all();
        #duyệt qua 
        foreach($abet as $abet){
            ## duyệt qua các tiêu chí các lần đánh giá
            $so_lan_danh_gia=0;
            $dat_A=$dat_B=$dat_C=$dat_D=0;
            $temp=[];
            foreach($ct_baiquyhoach as $ct){
                ### đếm tiêu chí được đánh giá mấy lần, chỉ tính tren giảng viên đang đang nhập (maCanBo=1)
                $tk=thongke_abet_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->where('maCanBo',1)->get();
                if(count($tk)>0){
                    $so_lan_danh_gia+=count($tk);
                }
            }
            if($so_lan_danh_gia>0){
                array_push($temp,$abet->maChuanAbetVB);
                if(Session::get('language') && Session::get('language')=='en'){
                    array_push($temp,$abet->tenChuanAbet_EN);
                }else{
                    array_push($temp,$abet->tenChuanAbet);
                }
            }
            
            foreach($ct_baiquyhoach as $ct){
                $thongke_abet_hocphan=thongke_abet_hocphan::where('maCTBaiQH',$ct->maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->get();
                
                if(count($thongke_abet_hocphan)==1){
                    
                    $tong=1;
                    $tong=$thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                    
                    if($tong!=0){
                        switch ($so_lan_danh_gia) {
                            case 1:
                                # code...
                                $dat_A=$dat_A+($thongke_abet_hocphan[0]->dat_A)/$tong;
                                $dat_B=$dat_B+($thongke_abet_hocphan[0]->dat_B)/$tong;
                                $dat_C=$dat_C+($thongke_abet_hocphan[0]->dat_C)/$tong;
                                $dat_D=$dat_D+($thongke_abet_hocphan[0]->dat_D)/$tong;
                                break;
                            case 2:
                                $dat_A=$dat_A+($thongke_abet_hocphan[0]->dat_A*0.5)/$tong;
                                $dat_B=$dat_B+($thongke_abet_hocphan[0]->dat_B*0.5)/$tong;
                                $dat_C=$dat_C+($thongke_abet_hocphan[0]->dat_C*0.5)/$tong;
                                $dat_D=$dat_D+($thongke_abet_hocphan[0]->dat_D*0.5)/$tong;
                                break;
                            case 3:
                                $dat_A=$dat_A+($thongke_abet_hocphan[0]->dat_A)*($ct->trongSo/100)/$tong;
                                $dat_B=$dat_B+($thongke_abet_hocphan[0]->dat_B)*($ct->trongSo/100)/$tong;
                                $dat_C=$dat_C+($thongke_abet_hocphan[0]->dat_C)*($ct->trongSo/100)/$tong;
                                $dat_D=$dat_D+($thongke_abet_hocphan[0]->dat_D)*($ct->trongSo/100)/$tong;
                                break;
                            default:
                                # code...
                                break;
                        }
                        
                    }
                }else{
                    if(count($thongke_abet_hocphan)==2){
                        $tong=1;
                        $tile_A=$tile_B=$tile_C=$tile_D=0;     
                        $tong= $thongke_abet_hocphan[0]->dat_A+$thongke_abet_hocphan[0]->dat_B+$thongke_abet_hocphan[0]->dat_C+$thongke_abet_hocphan[0]->dat_D+$thongke_abet_hocphan[0]->chua_dat;
                        if($tong!=0){
                            $tile_A=$tile_A+(($thongke_abet_hocphan[0]->dat_A)/$tong)*0.5;
                            $tile_B=$tile_B+(($thongke_abet_hocphan[0]->dat_B)/$tong)*0.5;
                            $tile_C=$tile_C+(($thongke_abet_hocphan[0]->dat_C)/$tong)*0.5;
                            $tile_D=$tile_D+(($thongke_abet_hocphan[0]->dat_D)/$tong)*0.5;
                        }
                                    
                        $tong= $thongke_abet_hocphan[1]->dat_A+$thongke_abet_hocphan[1]->dat_B+$thongke_abet_hocphan[1]->dat_C+$thongke_abet_hocphan[1]->dat_D+$thongke_abet_hocphan[1]->chua_dat;
                        if($tong!=0){
                            $tile_A=$tile_A+(($thongke_abet_hocphan[1]->dat_A)/$tong)*0.5;
                            $tile_B=$tile_B+(($thongke_abet_hocphan[1]->dat_B)/$tong)*0.5;
                            $tile_C=$tile_C+(($thongke_abet_hocphan[1]->dat_C)/$tong)*0.5;
                            $tile_D=$tile_D+(($thongke_abet_hocphan[1]->dat_D)/$tong)*0.5;
                        }
                        
                        if($dat_A!=0 || $dat_B!=0 || $dat_C!=0 || $dat_D!=0){
                            switch ($so_lan_danh_gia) {
                                case 1:
                                    # code...
                                    $dat_A=$dat_A+$tile_A;
                                    $dat_B=$dat_B+$tile_B;
                                    $dat_C=$dat_C+$tile_C;
                                    $dat_D=$dat_D+$tile_D;
                                    break;
                                case 2:
                                    $dat_A=$dat_A+$tile_A*0.5;
                                    $dat_B=$dat_B+$tile_B*0.5;
                                    $dat_C=$dat_C+$tile_C*0.5;
                                    $dat_D=$dat_D+$tile_D*0.5;
                                    break;
                                case 3:
                                    $dat_A=$dat_A+$tile_A*($ct->trongSo/100);
                                    $dat_B=$dat_B+$tile_B*($ct->trongSo/100);
                                    $dat_C=$dat_C+$tile_C*($ct->trongSo/100);
                                    $dat_D=$dat_D+$tile_D*($ct->trongSo/100);
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            
                        }else{
                            $dat_A=$dat_A+$tile_A;
                            $dat_B=$dat_B+$tile_B;
                            $dat_C=$dat_C+$tile_C;
                            $dat_D=$dat_D+$tile_D;
                        }
                    }
                }
                if($ct->maCTBaiQH==547){
                    //return $dat_A;
                }
                
            }
            
            if($so_lan_danh_gia>0){
                array_push($temp,number_format($dat_A*100,2));
                array_push($temp,number_format($dat_B*100,2));
                array_push($temp,number_format($dat_C*100,2));
                array_push($temp,number_format($dat_D*100,2));
                array_push($thongke,$temp); 
            }    
        }
        # trả về kết quả cuối cùng
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        return view('giangvien.thongketheotungmon.abet.view_abet_tung_mon',['bieuDo'=>$thongke,'hocPhan'=>$hocPhan]);
    }
}
