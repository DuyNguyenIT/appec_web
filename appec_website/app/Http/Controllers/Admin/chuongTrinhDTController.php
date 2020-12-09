<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class chuongTrinhDTController extends Controller
{
    public function index(Type $var = null)
    {
        return view('admin.chuongtrinhDT');
    }
}
