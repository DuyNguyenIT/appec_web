<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\WordController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AdWordController extends Controller
{
    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        return WordController::in_de_cuong_mon_hoc($maHocPhan);
    }
}