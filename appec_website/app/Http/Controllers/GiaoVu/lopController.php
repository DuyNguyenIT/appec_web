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

    public function xem_danh_sach_sinh_vien($maLop)
    {
        $dssv=sinhVien::where('isDelete',false)
        ->get();
        return view('giaovu.lop.danhsachSV',['dssv'=>$dssv,'maLop'=>$maLop]);
    }
}
