<?php

namespace App\Http\Controllers\GiaoVu;

use App\Models\lop;
use App\Models\sinhVien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    public function index(Request $request)
    {
        $count_class=lop::count('maLop');
        $count_student=sinhVien::count('maSSV');
        return view('giaovu.home',compact('count_class','count_student'));
    }
}
