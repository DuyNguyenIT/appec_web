<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    public function index(Type $var = null)
    {
        return view('login');
    }
}
