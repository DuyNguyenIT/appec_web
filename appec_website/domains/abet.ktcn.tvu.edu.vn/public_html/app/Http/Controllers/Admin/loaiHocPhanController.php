<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\loaiHocPhan;
use Illuminate\Http\Request;
use Session;

class loaiHocPhanController extends Controller
{
    public function index()
    {
        $lhp=loaiHocPhan::where('isDelete',false)->orderBy('maLoaiHocPhan','desc')->get();
        return view('admin.loaihocphan',['loaihocphan'=>$lhp]);
    }

    public function them(Request $request)
    {
        $lhp=new loaiHocPhan();
        $lhp->maLoaiHocPhan=$request->maLoaiHocPhan;
        $lhp->tenLoaiHocPhan=$request->tenLoaiHocPhan;
        $lhp->save();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công', 'Thông báo');
        } else {
            alert()->success('Added successfully', 'Message');
        }
        return redirect('/quan-ly/loai-hoc-phan');      
    }

    public function sua(Request $request)
    {
        $lhp=loaiHocPhan::where('maLoaiHocPhan',$request->maLoaiHocPhan)->first();
        $lhp->tenLoaiHocPhan=$request->tenLoaiHocPhan;
        $lhp->update();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công!!','Thông báo');
        } else {
            alert()->success('Edited successfully!!','Message');
        }
        return redirect('/quan-ly/loai-hoc-phan');     
    }

    public function xoa($maLoaiHocPhan)
    {
        $lhp=loaiHocPhan::find($maLoaiHocPhan)->delete();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Xóa thành công!!','Thông báo');
        } else {
            alert()->success('Deleted successfully!!','Message');
        }
        return redirect('/quan-ly/loai-hoc-phan');
       
    }
}
