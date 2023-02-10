<?php

namespace App\Http\Controllers\BoMon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BMHomeController extends Controller
{
    public function index()
    {
        return view('bomon.home');
    }
}
