<?php

namespace App\Http\Controllers\BoMon;

use Session;
use App\Models\lop;
use App\Models\sinhVien;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

class BMlopController extends Controller
{
    public function index()
    {
        $lop=lop::where('isDelete',false)->orderBy('maLop','desc')->get();
        foreach ($lop as $x) {
            $x->countsv=sinhVien::where('maLop',$x->maLop)->count('maSSV');
        }
        return view('bomon.lop.lop',['lop'=>$lop]);
    }

   public function addClass(Request $request)
    {
        $lop=lop::where('maLop',$request->maLop)->first();
        if($lop){
            CommonController::warning_notify('Lớp đã tồn tại!!!','Class is exist');
            return redirect('/bo-mon/quan-ly-lop');
        }
        lop::create($request->all());
        CommonController::success_notify('Thêm thành công!','Added successfully!');
        return redirect('/bo-mon/quan-ly-lop');
    }


    public function editClass(Request $request)
    {
        lop::updateOrCreate(['maLop'=>$request->maLop],['tenLop'=>$request->tenLop,'namTS'=>$request->namTS]);
        CommonController::success_notify('Sửa thành công','Edited successfully');
        return redirect('/bo-mon/quan-ly-lop');
    }

    public function delClass($maLop)
    {
        if(sinhVien::where('maLop',$maLop)->count('maSSV')>0){
            CommonController::wacrning_notify('Lớp đã có sinh viên, không thể xóa!!!','Class has students,delete denied!!!');
            return redirect('/bo-mon/quan-ly-lop');
        }
         lop::find($maLop)->delete();
         CommonController::success_notify('Xóa thành công','Deleted successfully');
         return redirect('/bo-mon/quan-ly-lop');
         
    }
    public function xem_danh_sach_sinh_vien($maLop)
    {
        Session::put('maLop',$maLop);
        $dssv=sinhVien::where('isDelete',false)->where('maLop',$maLop)->get();
        return view('bomon.lop.danhsachsv',['dssv'=>$dssv,'maLop'=>$maLop]);
    }

    public function them_sinh_vien_lop(Request $request)
    {
        //kiem tra sinh vien da ton tai
        if (sinhVien::find($request->maSSV)) {
            CommonController::wacrning_notify('Sinh viên đã tồn tại','The student exitsted');

        } else {
            # code...
        }
        
    }
}
