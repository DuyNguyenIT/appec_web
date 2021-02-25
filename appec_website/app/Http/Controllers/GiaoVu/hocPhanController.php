<?php

namespace App\Http\Controllers\GiaoVu;

use App\Http\Controllers\Controller;
use App\Models\baiQuyHoach;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\hocPhan;
use App\Models\lop;
use Illuminate\Http\Request;

class hocPhanController extends Controller
{
    public function index(Type $var = null)
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
        'giangvien'=>$giangvien,'lop'=>$lop]);
    }

    public function them_hoc_phan_giang_day(Request  $request)
    {
        //tạo bài quy hoạch mới
        $bqh=new baiQuyHoach();
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

        return redirect('/giao-vu/hoc-phan-giang-day')->with('success','Thêm thành công!!!');
    }
}
