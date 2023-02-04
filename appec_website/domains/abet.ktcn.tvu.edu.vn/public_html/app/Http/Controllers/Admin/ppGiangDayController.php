<?php

namespace App\Http\Controllers\Admin;

use App\Models\ppGiangDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ppGiangDayController extends Controller
{
    public function index() //hàm xóa
    {
        $pp=ppGiangDay::orderBy('maPP','asc')->get();
        return view('admin.ppGiangDay',['ppGiangDay'=>$pp]);
    }

    public function them(Request $request) //hàm thêm
    {
        ppGiangDay::create($request->all());
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công!!','Thông báo');
        } else {
            alert()->success('Added successfully!!','Message');
        }
        return redirect('/quan-ly/phuong-phap-giang-day');

    }

    public function sua(Request $request) //hàm sửa
    {
        ppGiangDay::updateOrCreate(['maPP'=>$request->maPP],['tenPP'=>$request->tenPP,'tenPP_EN'=>$request->tenPP_EN]);
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công!!','Thông báo');
        } else {
            alert()->success('Edited successfully!!','Message');
        }
        return redirect('/quan-ly/phuong-phap-giang-day');

    }

    public function xoa($maPP)
    {
        ppGiangDay::find('$maPP')->delete();
        return redirect('/quan-ly/phuong-phap-giang-day');
    }
}
