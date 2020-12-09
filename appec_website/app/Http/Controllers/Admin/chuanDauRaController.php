<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class chuanDauRaController extends Controller
{
    public function index(Type $var = null)
    {
        return view('admin.chuandaura.chuanDR1');
    }

    public function chuanDR2(Type $var = null)
    {
        return view('admin.chuandaura.chuanDR2')
    }
}
