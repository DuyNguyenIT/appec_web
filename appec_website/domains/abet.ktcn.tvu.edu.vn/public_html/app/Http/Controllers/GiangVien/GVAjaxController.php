<?php

namespace App\Http\Controllers\giangvien;

use Session;
use App\Models\muc;
use App\Models\CDR2;
use App\Models\CDR3;
use App\Models\cauHoi;
use App\Models\kqHTHP;
use App\Models\cdr2_abet;
use App\Models\noiDungQH;
use App\Models\cau_hoi_ndqh;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\tieuChuanDanhGia;
use App\Http\Controllers\Controller;


//controller dieu khien cac ham lien quan den goi ajax trong giang vien
class GVAjaxController extends Controller
{
    public function get_muc_by_ma_chuong($maChuong)
    {
        if($maChuong!=-1){
            return muc::get_by_machuong($maChuong);
        }else{
            return muc::get_all_by_maHocPhan(Session::get('maHocPhan'));
        }
        
    }

    public function get_cau_hoi_trac_nghiem_by_mamuc($maMuc)
    {
        if($maMuc!=-1){
             return cauHoi::get_cau_hoi_trac_nghiem_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }
        else{
            return cauHoi::get_cau_hoi_trac_nghiem(Session::get('maHocPhan'));
        }
       
    }

    public function get_cau_hoi_tu_luan_by_mamuc($maMuc)
    {
        if($maMuc!=-1){ //chọn mục cụ thể
            return cauHoi::get_cau_hoi_tu_luan_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }else{//chọn tât cả
            return cauHoi::get_cau_hoi_tu_luan(Session::get('maHocPhan'));
        }
    }

    public function get_cau_hoi_thuc_hanh_by_mamuc($maMuc)
    {
        if($maMuc!=-1){ //chọn mục cụ thể
            return cauHoi::get_cau_hoi_thuc_hanh_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }else{//chọn tât cả
            return cauHoi::get_cau_hoi_thuc_hanh(Session::get('maHocPhan'));
        }
    }

    public function get_abet_by_cdr3($maCDR3)
    {
        $cdr3=CDR3::find($maCDR3);
        $cdr2=CDR2::where('maCDR2',$cdr3->maCDR2)->first();
        return cdr2_abet::where('maCDR2',$cdr2->maCDR2)
        ->join('chuan_abet',function($x){
            $x->on('cdr_cd2_chuan_abet.maChuanAbet','=','chuan_abet.maChuanAbet');
        })->get();
    }

     //
     public function get_tieu_chuan_by_NDQH($maNoiDungQH)
     {
         $tc=tieuChuanDanhGia::where('isDelete',false)->where('maNoiDungQH',$maNoiDungQH)->get();
         $data="";
         foreach ($tc as $x) {
             $data=$data."<option value='".$x->maTCDG."'>".$x->tenTCDG.'-'.$x->diem." điểm</option>";
         }
         return response()->json($data);
     }
     
    public function get_kqht_by_NDQH($maNoiDungQH)
    {
        $maKQHT=noiDungQH::where('maNoiDungQH',$maNoiDungQH)->pluck('maKQHT');
        $kqht=kqHTHP::where('maKQHT',$maKQHT)->get();
        $data="";
        foreach($kqht as $x){
            $data=$data."<option value='".$x->maKQHT."'>".$x->maKQHTVB.'-'.$x->tenKQHT."</option>";
        }
        return $data;
    }

    public function get_cdr3_by_NDQH($maNoiDungQH)
    {
        $maKQHT=noiDungQH::where('maNoiDungQH',$maNoiDungQH)->pluck('maKQHT');
        $hp_kqht=hocPhan_kqHTHP::where('maHocPhan',session::get('maHocPhan'))->where('maKQHT',$maKQHT)->pluck('maCDR3');
        $cdr3=CDR3::whereIn('maCDR3',$hp_kqht)->orderBy('maCDR3VB')->get();
        $data="";
        foreach($cdr3 as $x){
            $data=$data."<option value='".$x->maCDR3."'>".$x->maCDR3VB.'-'.$x->tenCDR3."</option>";
        }
        return $data;
    }


    public function get_cdr3_from_maCauHoi($maCauHoi)
    {
        //noi dung qh
        $arr_ndqh=noiDungQH::where('maCTBaiQH',Session::get('maCTBaiQH'))->pluck('maNoiDungQH');
        $cau_hoi_ndqh=cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->whereIn('maNoiDungQH',$arr_ndqh)->first();

        if($cau_hoi_ndqh){
            //noi dung qh-->kqht-->cdr3_arr
            $ndqh=noiDungQH::where('maNoiDungQH',$cau_hoi_ndqh->maNoiDungQH)->first();
            $cdr3_arr=hocPhan_kqHTHP::where('maHocPhan',Session::get('maHocPhan'))->where('maKQHT',$ndqh->maKQHT)->pluck('maCDR3');   
            //cdr3_arr---[CDR3]
            $cdr3=CDR3::whereIn('maCDR3',$cdr3_arr)->get();
            return $cdr3;
        }else{
            $cdr3=CDR3::all();
        }
        
        //return
       
        return $cdr3;
    }
}
