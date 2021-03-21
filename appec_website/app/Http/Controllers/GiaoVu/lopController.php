<?php

namespace App\Http\Controllers\GiaoVu;

use App\Http\Controllers\Controller;
use App\Models\lop;
use App\Models\sinhVien;
use Illuminate\Http\Request;

class lopController extends Controller
{
    public function index(Type $var = null)
    {
        $lop=lop::where('isDelete',false)
        ->get();
        return view('giaovu.lop.lop',['lop'=>$lop]);
    }

    public function addClass(Request $request)
    {
        $lop=lop::where('maLop',$request->maLop)->first();
        if($lop){
            alert()->waring('Class is exist','Warning');
            return back();
        }
        lop::create($request->all());
        alert()->success('Adding successfully','Message');
        return back();
    }

    public function xem_danh_sach_sinh_vien($maLop)
    {
        $dssv=sinhVien::where('isDelete',false)
        ->where('maLop',$maLop)
        ->get();
        return view('giaovu.lop.danhsachsv',['dssv'=>$dssv,'maLop'=>$maLop]);
    }
}
