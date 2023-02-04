<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cNganh;
use App\Models\nganh;
use Illuminate\Http\Request;
use Session;

class nganhController extends Controller
{
    public function index()
    {
        //$nganh=nganh::where('isDelete',false)->get();
        $nganh=nganh::all();
        return view('admin.nganh',['nganh'=>$nganh]);
    }

    public function them(Request $request)
    {
        $nganh=new nganh();
        $nganh->maNganh=$request->maNganh;
        $nganh->tenNganh=$request->tenNganh;
        $nganh->save();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công', 'Thông báo')->persistent('Close');
        } else {
            alert()->success('Added successfully', 'Message')->persistent('Close');
        }
        return redirect('/quan-ly/nganh-hoc');
    }

    public function sua(Request $request)
    {
        $nganh=nganh::where('maNganh',$request->maNganh)->first();
        $nganh->maNganh=$request->maNganh;
        $nganh->tenNganh=$request->tenNganh;
        $nganh->update();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công!!','Thông báo');
        } else {
            alert()->success('Edited successfully!!','Message');
        }
        return redirect('/quan-ly/nganh-hoc');
    }

    public function xoa($maNganh)
    {
        $nganh=nganh::find($maNganh)->delete();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Xóa thành công!!','Thông báo');
        } else {
            alert()->success('Deleted successful', 'Message');
        }
        return redirect('/quan-ly/nganh-hoc');     
    }
}
