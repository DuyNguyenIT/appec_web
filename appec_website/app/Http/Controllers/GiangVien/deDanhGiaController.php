<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class deDanhGiaController extends Controller
{
    public function index()
    {
        return view('giangvien.deDanhGia');
    }
}
