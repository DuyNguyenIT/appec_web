<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\WordController;

class AdWordController extends Controller
{

    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        WordController::in_de_cuong_mon_hoc($maHocPhan);
    }

}
