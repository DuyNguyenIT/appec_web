<?php

namespace App\Http\Controllers\GiaoVu;

use Session;
use Carbon\Carbon;
use App\Models\lop;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\baiQuyHoach;
use Illuminate\Http\Request;
use App\Models\sinhvien_hocphan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

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
        $gd_data=giangDay::where('giangday.isDelete',false)->get();
        //giang day
        $gd_rs=giangDay::where('giangday.isDelete',false)
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->distinct()
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop']);
        
        //dem so sinh vien trong moi hoc phan giang day
        foreach ($gd_rs as $x) {
            $x->countsv=sinhvien_hocphan::get_list_sv($x->maHocPhan,$x->maLop,$x->maHK,$x->namHoc)->count('maSSV');;
        }
        
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

       
        return view('giaovu.hocphan.hocphan',['giangday'=>$gd_rs,'hocphan'=>$hp,
        'giangvien'=>$giangvien,'lop'=>$lop,'years_array'=>$years_array]);
    }

    public function them_hoc_phan_giang_day(Request  $request)
    {

        //check da ton tai
        $check=giangDay::where('maHocPhan',$request->maHocPhan)
        ->where('maHK',$request->maHK)
        ->where('namHoc',$request->namHoc)
        ->where('maLop',$request->maLop)
        ->where('maGV',$request->maGV)->count();

        if($check>0)
        {
            CommonController::warning_notify('Phân công đã tồn tại, hãy kiểm tra lại','Plan is exist, please check');
            return redirect('/giao-vu/hoc-phan-giang-day');
        }

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
        
        CommonController::warning_notify('Thêm thành công!!!','Added successfully!!!');
        return redirect('/giao-vu/hoc-phan-giang-day');
    }

    public function xem_danh_sach_sinh_vien($maHocPhan,$maLop,$maHK,$namHoc)
    {
        Session::put('maHocPhan',$maHocPhan);
        Session::put('maLop',$maLop);
        Session::put('maHK',$maHK);
        Session::put('namHoc',$namHoc);

        $hocphan=hocPhan::getHocPhanByMaHocPhan($maHocPhan);
        $dssv=sinhvien_hocphan::get_list_sv($maHocPhan,$maLop,$maHK,$namHoc);
        return view('giaovu.hocphan.danhsachSV',compact('dssv','hocphan','maLop','maHK','namHoc'));
    }

    public function xoa_hocphan_giangday($maHocPhan,$maLop,$maHK,$namHoc)
    {
        $xoabangcon=giangDay::where('isDelete',false)
                                ->where('maHocPhan',$maHocPhan)
                                ->where('maLop',$maLop)
                                ->where('maHK',$maHK)
                                ->where('namHoc',$namHoc)
                                ->groupBy('maBaiQH')
                                ->get();
        //return $xoabangcon;
        foreach($xoabangcon as $xoa)
        {
            if(ct_bai_quy_hoach::where('isDelete',false)->where('maBaiQH',$xoa->maBaiQH)->count('maBaiQH')==0)//bГ i quy hoбєЎch chЖ°a Д‘Ж°б»Јc sб»­ dб»Ґng
            {
                baiQuyHoach::find($xoa->maBaiQH)->delete();//chЖ°a sб»­ dб»Ґng thГ¬ xГіa bбєЈng bГ i quy hoбєЎch vГ  xГіa giбєЈng dбєЎy
                giangDay::where('isDelete',false)
                        ->where('maHocPhan',$maHocPhan)
                        ->where('maLop',$maLop)
                        ->where('maHK',$maHK)
                        ->where('namHoc',$namHoc)
                        ->delete();
            }
            else//bГ i quy hoбєЎch Д‘ГЈ Д‘Ж°б»Јc sб»­ dб»Ґng thГ¬ chб»‰ xГіa phГўn cГґng theo kiб»ѓu bбє­t isDelete vб»Ѓ true
            {
                
                
                giangDay::where('isDelete',false)
                ->where('maHocPhan',$maHocPhan)
                ->where('maLop',$maLop)
                ->where('maHK',$maHK)
                ->where('namHoc',$namHoc)
                ->update(['isDelete' => true]);
            }
        }
        
        CommonController::success_notify('Xóa thành công!','Deleted successfully');
       return redirect('/giao-vu/hoc-phan-giang-day');
        
    }

    public function xoa_hocphan_giangday_gv($maHocPhan,$maLop,$maHK,$namHoc,$maGV)
    {
        $xoabangcon=giangDay::where('isDelete',false)
                                ->where('maHocPhan',$maHocPhan)
                                ->where('maLop',$maLop)
                                ->where('maHK',$maHK)
                                ->where('namHoc',$namHoc)
                                ->where('maGV',$maGV)
                                ->groupBy('maBaiQH')
                                ->get();
        //return $xoabangcon;
        foreach($xoabangcon as $xoa)
        {
            if(ct_bai_quy_hoach::where('isDelete',false)->where('maBaiQH',$xoa->maBaiQH)->count('maBaiQH')==0)//bГ i quy hoбєЎch chЖ°a Д‘Ж°б»Јc sб»­ dб»Ґng
            {
                baiQuyHoach::find($xoa->maBaiQH)->delete();//chЖ°a sб»­ dб»Ґng thГ¬ xГіa bбєЈng bГ i quy hoбєЎch vГ  xГіa giбєЈng dбєЎy
                giangDay::where('isDelete',false)
                        ->where('maHocPhan',$maHocPhan)
                        ->where('maLop',$maLop)
                        ->where('maHK',$maHK)
                        ->where('namHoc',$namHoc)
                        ->where('maGV',$maGV)
                        ->delete();
            }
            else//bГ i quy hoбєЎch Д‘ГЈ Д‘Ж°б»Јc sб»­ dб»Ґng thГ¬ chб»‰ xГіa phГўn cГґng theo kiб»ѓu bбє­t isDelete vб»Ѓ true
            {
                
                
                giangDay::where('isDelete',false)
                ->where('maHocPhan',$maHocPhan)
                ->where('maLop',$maLop)
                ->where('maHK',$maHK)
                ->where('namHoc',$namHoc)
                ->where('maGV',$maGV)
                ->update(['isDelete' => true]);
            }
        }
        
        CommonController::success_notify('Xóa thành công phân công giáo viên trong nhóm','Successfully deleted the teacher assignment in the group');
       return redirect('/giao-vu/hoc-phan-giang-day');
        
    }
    

}
