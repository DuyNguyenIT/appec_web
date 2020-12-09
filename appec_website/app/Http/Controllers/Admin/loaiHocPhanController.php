<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loaiHocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        return view('admin.loaihocphan');
    }
}
