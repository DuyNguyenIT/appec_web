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
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/khoi-kien-thuc');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/khoi-kien-thuc');
        }
    }

    public function sua(Request $request)
    {
        try {
            $kkt=khoiKienThuc::where('maKhoiKT',$request->maKhoiKT)->first();
            $kkt->tenKhoiKT=$request->tenKhoiKT;
            $kkt->update();
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/khoi-kien-thuc');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed');
            return redirect('/quan-ly/khoi-kien-thuc');
        }
    }

    public function xoa($maKhoiKT)
    {
        try {
            $kkt=khoiKienThuc::where('maKhoiKT',$maKhoiKT)->first();
            $kkt->isDelete=true;
            $kkt->update();
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/khoi-kien-thuc');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/khoi-kien-thuc');
        }
    }
}
