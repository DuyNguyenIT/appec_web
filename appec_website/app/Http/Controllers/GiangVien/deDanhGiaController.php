<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class deDanhGiaController extends Controller
{
    public function index(Type $var = null)
    {
        return view('giangvien.deDanhGia');
    }
}
