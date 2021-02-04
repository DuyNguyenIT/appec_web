<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\he;
use Illuminate\Http\Request;

class heController extends Controller
{
    public function index(Type $var = null)
    {
        $he=he::where('isDelete',false)->orderBy('maHe','desc')->get();
        return view('admin.he',['he'=>$he]);
    }

    public function them_he(Request $request)
    {
        try {
            $he=new he();
            $he->maHe=$request->maHe;
            $he->tenHe=$request->tenHe;
            $he->save();
            return redirect('/quan-ly/he')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/he')->with('warning','Lỗi: '.$th);
        }
       
    }

    public function sua_he(Request $request)
    {
        try {
            $he=he::where('maHe',$request->maHe)->first();
            $he->tenHe=$request->tenHe;
            $he->update();
            return redirect('/quan-ly/he')->with('success','Sửa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/he')->with('warning','Lỗi: '.$th);
        }
        
    }

    public function xoa_he($maHe)
    {
        try {
            $he=he::where('maHe',$maHe)->first();
            $he->isDelete=true;
            $he->update();
            return redirect('/quan-ly/he')->with('sucess','Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/he')->with('warning','Lỗi: '.$th);
        }
       
    }
}
