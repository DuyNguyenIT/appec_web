<?php

namespace App\Http\Controllers\GiaoVu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class lopController extends Controller
{
    public function index(Type $var = null)
    {
        return view('giaovu.lop');
    }
}
