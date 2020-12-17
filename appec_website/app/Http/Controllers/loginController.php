<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class loginController extends Controller
{
    public function index(Type $var = null)
    {
        return view('login');
    }

    public function logout(Type $var = null)
    {
        Session::flush();
        return view('login');
    }
}
