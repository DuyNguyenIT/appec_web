<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\loaiHocPhan;
use Illuminate\Http\Request;

class loaiHocPhanController extends Controller
{
    public function index()
    {
        $lhp=loaiHocPhan::where('isDelete',false)->orderBy('maLoaiHocPhan','desc')->get();
        return view('admin.loaihocphan',['loaihocphan'=>$lhp]);
    }

    public function them(Request $request)
    {
        try {
            $lhp=new loaiHocPhan();
            $lhp->maLoaiHocPhan=$request->maLoaiHocPhan;
            $lhp->tenLoaiHocPhan=$request->tenLoaiHocPhan;
            $lhp->save();
            return redirect('/quan-ly/loai-hoc-phan')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/loai-hoc-phan')->with('warning','Lỗi: '.$th);
        }
       
    }

    public function sua(Request $request)
    {
        try {
            $lhp=loaiHocPhan::where('maLoaiHocPhan',$request->maLoaiHocPhan)->first();
            $lhp->tenLoaiHocPhan=$request->tenLoaiHocPhan;
            $lhp->update();
            return redirect('/quan-ly/loai-hoc-phan')->with('success','Sửa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/loai-hoc-phan')->with('warning','Lỗi: '.$th);
        }
        
    }

    public function xoa($maLoaiHocPhan)
    {
        try {
            $lhp=loaiHocPhan::where('maLoaiHocPhan',$maLoaiHocPhan)->first();
            $lhp->isDelete=true;
            $lhp->update();
            return redirect('/quan-ly/loai-hoc-phan')->with('sucess','Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/loai-hoc-phan')->with('warning','Lỗi: '.$th);
        }
       
    }
}
