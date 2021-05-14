<?php

namespace App\Http\Controllers\GiaoVu;

use Carbon\Carbon;
use App\Models\lop;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\baiQuyHoach;
use Illuminate\Http\Request;
use App\Models\sinhvien_hocphan;
use App\Http\Controllers\Controller;
use Session;

class hocPhanController extends Controller
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
        $gd_data=giangDay::where('giangday.isDelete',false)
        ->get();
        //giang day
        $gd_rs=giangDay::where('giangday.isDelete',false)
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->distinct()
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop']);
        //count student
        foreach ($gd_rs as $x) {
            $count=sinhvien_hocphan::where('maHocPhan',$x->maHocPhan)
            ->where('maLop',$x->maLop)->where('maHK',$x->maHK)
            ->where('namHoc',$x->namHoc)->count('maSSV');
            $x->countsv=$count;
        }
        

        //------t&#7841;o combobox n&#259;m h&#7885;c
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

       
        return view('giaovu.hocphan.hocphan',['giangday'=>$gd_rs,'hocphan'=>$hp,
        'giangvien'=>$giangvien,'lop'=>$lop,'years_array'=>$years_array]);
    }

    public function them_hoc_phan_giang_day(Request  $request)
    {
        //tạo bài quy hoạch mới
        $bqh=new baiQuyHoach();
        $bqh->tenBaiQH='text';
        $bqh->noiDungBaiQH='text';
        $bqh->save();
        $bqh=baiQuyHoach::where('isDelete',false)->orderBy('maBaiQH','desc')->first();

        //tạo giảng dạy
        $gd=new giangDay();
        $gd->maHocPhan=$request->maHocPhan;
        $gd->maLop=$request->maLop;
        $gd->maGV=$request->maGV;
        $gd->maHK=$request->maHK;
        $gd->namHoc=$request->namHoc;
        $gd->maBaiQH=$bqh->maBaiQH;
        $gd->maCDR3=1;
        $gd->save();

        if(session::has('language') && session::get('language'=='vi')){
            alert()->success('Thêm thành công!!!','Thông báo');
        }else{
            alert()->success('Added successfully!!!','Message');
        }
        return redirect('/giao-vu/hoc-phan-giang-day');
    }

    public function xem_danh_sach_sinh_vien($maHocPhan,$maLop,$maHK,$namHoc)
    {
        Session::put('maHocPhan',$maHocPhan);
        Session::put('maLop',$maLop);
        Session::put('maHK',$maHK);
        Session::put('namHoc',$namHoc);
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $dssv=sinhvien_hocphan::where('maHocPhan',$maHocPhan)->where('maLop',$maLop)
        ->where('maHK',$maHK)->where('namHoc',$namHoc)->with('sinhvien')->get();
       
        return view('giaovu.hocphan.danhsachSV',compact('dssv','hocphan','maLop','maHK','namHoc'));
    }
}
