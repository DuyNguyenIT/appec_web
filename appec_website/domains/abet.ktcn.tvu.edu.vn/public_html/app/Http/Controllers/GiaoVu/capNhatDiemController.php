<?php

namespace App\Http\Controllers\GiaoVu;

use Carbon\Carbon;
use App\Models\lop;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use Illuminate\Http\Request;
use App\Models\sinhvien_hocphan;
use App\Http\Controllers\Controller;

class capNhatDiemController extends Controller
{
    public function index()
    {
        //học phần
        $hp=hocPhan::where('isDelete',false)
        ->get();
        //giảng viên
        $giangvien=giangVien::where('isDelete',false)
        ->get();
        //lớp 
        $lop=lop::where('isDelete',false)
        ->get();
        //giang day data
        $gd_data=giangDay::where('giangday.isDelete',false)->get();
        //giang day
        $gd_rs=giangDay::distinct('namHoc')->orderBy('namHoc','desc')->get('namHoc');
        // ->orderBy('giangday.namHoc','DESC')->orderBy('giangday.maHK','DESC')
        // ->join('hoc_phan',function($x){
        //     $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
        //     ->where('hoc_phan.isDelete',false);
        // })
        // ->distinct()
        // ->join('ct_bai_quy_hoach',function($x){
        //     $x->on('ct_bai_quy_hoach.maBaiQH','=','giangday.maBaiQH');
        // })
        // ->get(['giangday.id','hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop','ct_bai_quy_hoach.maLoaiHTDG','ct_bai_quy_hoach.maLoaiDG']);
      
        
        //dem so sinh vien trong moi hoc phan giang day
        // foreach ($gd_rs as $x) {
        //     $x->countsv=sinhvien_hocphan::get_list_sv($x->maHocPhan,$x->maLop,$x->maHK,$x->namHoc)->count('maSSV');;
        // }
        
        //------tao combobox nam hoc
        $date = new Carbon();   
        $current_year=$date->year;
        $years_array=[];
        for ($i=1; $i<=5 ; $i++) { 
            array_push($years_array,($current_year-1).'-'.($current_year));
            $current_year=$current_year-1;
        }


        foreach ($gd_rs as $x) {
            $gv=[];
            foreach ($gd_data as $y) {
                if($y->maHocPhan==$x->maHocPhan && $y->maHK==$x->maHK && $y->namHoc==$x->namHoc && $y->maLop==$x->maLop){
                    if(!array_search($y->maGV,$gv))
                        array_push($gv,$y->maGV);
                }
                $temp=[];
                foreach (array_unique($gv) as $t) { 
                    $temp_gv=giangVien::where('isDelete',false)
                    ->where('maGV',$t)
                    ->first();
                    array_push($temp,$temp_gv);
                }
                $x->GV=$temp;
            }
        }
       return view('giaovu.capnhatdiem.capnhatdiem',['giangday'=>$gd_rs,'hocphan'=>$hp,
       'giangvien'=>$giangvien,'lop'=>$lop,'years_array'=>$years_array]);
    }

    public function hocphan($namHoc,$maHK)
    {
        $giangday=giangDay::where('giangday.isDelete',false)
        ->where('maHK',$maHK)->where('namHoc',$namHoc)
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->distinct()
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop']);
        $gd_data=giangDay::where('giangday.isDelete',false)->get();
        foreach ($giangday as $x) {
            $gv=[];
            foreach ($gd_data as $y) {
                if($y->maHocPhan==$x->maHocPhan && $y->maHK==$x->maHK && $y->namHoc==$x->namHoc && $y->maLop==$x->maLop){
                    if(!array_search($y->maGV,$gv))
                        array_push($gv,$y->maGV);
                }
                $temp=[];
                foreach (array_unique($gv) as $t) { 
                    $temp_gv=giangVien::where('isDelete',false)
                    ->where('maGV',$t)
                    ->first();
                    array_push($temp,$temp_gv);
                }
                $x->GV=$temp;
            }
        }
        
        return view('giaovu.capnhatdiem.hocphan',compact('giangday','namHoc','maHK'));
    }


}
