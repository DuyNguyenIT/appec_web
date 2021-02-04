<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\khoiKienThuc;
use Illuminate\Http\Request;

class khoiKienThucController extends Controller
{
    public function index(Type $var = null)
    {
        $kkt=khoiKienThuc::where('isDelete',false)->orderBy('maKhoiKT','desc')->get();
        return view('admin.khoikienthuc',['khoikienthuc'=>$kkt]);
    }

    public function them(Request $request)
    {
        try {
            $kkt=new khoiKienThuc();
            $kkt->maKhoiKT=$request->maKhoiKT;
            $kkt->tenKhoiKT=$request->tenKhoiKT;
            $kkt->save();
            return redirect('/quan-ly/khoi-kien-thuc')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/khoi-kien-thuc')->with('warning','Lỗi: '.$th);
        }
    }

    public function sua(Request $request)
    {
        try {
            $kkt=khoiKienThuc::where('maKhoiKT',$request->maKhoiKT)->first();
            $kkt->tenKhoiKT=$request->tenKhoiKT;
            $kkt->update();
            return redirect('/quan-ly/khoi-kien-thuc')->with('success','Sửa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/khoi-kien-thuc')->with('warning','Lỗi: '.$th);
        }
    }

    public function xoa($maKhoiKT)
    {
        try {
            $kkt=khoiKienThuc::where('maKhoiKT',$maKhoiKT)->first();
            $kkt->isDelete=true;
            $kkt->update();
            return redirect('/quan-ly/khoi-kien-thuc')->with('sucess','Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/khoi-kien-thuc')->with('warning','Lỗi: '.$th);
        }
    }
}
