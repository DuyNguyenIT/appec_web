<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller
{
    public function index($lang)
    {
        if ($lang) {
            # code...
            Session::put('language',$lang);
        }
        return redirect()->back();
    }
}
