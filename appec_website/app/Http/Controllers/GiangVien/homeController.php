<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class homeController extends Controller
{
    public function index(Type $var = null)
    {
        Session::put('maGV',1234);
        return view('giangvien.home');
    }
}
