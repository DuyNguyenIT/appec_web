<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ppGiangDayController extends Controller
{
    public function index(Type $var = null)
    {
        return view('admin.ppGiangDay');
    }
}
