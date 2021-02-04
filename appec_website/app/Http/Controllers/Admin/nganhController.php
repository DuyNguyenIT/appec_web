<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cNganh;
use App\Models\nganh;
use Illuminate\Http\Request;

class nganhController extends Controller
{
    public function index(Type $var = null)
    {
        $nganh=nganh::where('isDelete',false)->get();
        return view('admin.nganh',['nganh'=>$nganh]);
    }

    public function them_nganh(Request $request)
    {
        try {
            $nganh=new nganh();
            $nganh->maNganh=$request->maNganh;
            $nganh->tenNganh=$request->tenNganh;
            $nganh->save();
            return redirect('/quan-ly/nganh-hoc')->with('success','Thêm thành công!');
    
        } catch (\Throwable $th) {
            return redirect('/quan-ly/nganh-hoc')->with('warning','Lỗi:'.$th);
        }
    }

    public function sua_nganh(Request $request)
    {
        try {
            $nganh=nganh::where('maNganh',$request->maNganh)->first();
            $nganh->maNganh=$request->maNganh;
            $nganh->tenNganh=$request->tenNganh;
            $nganh->update();
            return redirect('/quan-ly/nganh-hoc')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/nganh-hoc')->with('warning','Lỗi:'.$th);
        }
    }

    public function xoa_nganh($maNganh)
    {
        try {
            $nganh=nganh::where('maNganh',$maNganh)->first();
            $nganh->isDelete=true;
            $nganh->update();
            return redirect('/quan-ly/nganh-hoc')->with('success','Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/nganh-hoc')->with('warning','Lỗi:'.$th);

        }
        
    }
}
