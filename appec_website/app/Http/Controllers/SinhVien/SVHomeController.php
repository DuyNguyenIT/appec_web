<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SVHomeController extends Controller
{
    public function index(Type $var = null)
    {
        return view('sinhvien.home');
    }
}
