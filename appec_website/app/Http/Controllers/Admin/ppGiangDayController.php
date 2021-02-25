<?php

namespace App\Http\Controllers\Admin;

use App\Models\ppGiangDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ppGiangDayController extends Controller
{
    public function index(Type $var = null) //hàm xóa
    {
        $pp=ppGiangDay::orderBy('maPP','asc')->get();
        return view('admin.ppGiangDay',['ppGiangDay'=>$pp]);
    }

    public function them(Request $request) //hàm thêm
    {
        ppGiangDay::create($request->all());
        alert()->success('Thêm thành công!!','Thông báo');
        return back();
    }

    public function sua(Request $request) //hàm sửa
    {
        ppGiangDay::updateOrCreate(['maPP'=>$request->maPP],['tenPP'=>$request->tenPP]);
        alert()->success('Sửa thành công!!','Thông báo');
        return back();
    }

    public function xoa(Type $var = null)
    {
        # code...
    }
}
