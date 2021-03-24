<?php

namespace App\Models;

use App\Models\cauHoi;
use App\Models\phuongAnTuLuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dethi_cauhoituluan extends Model
{
    use HasFactory;
    protected $table = 'de_thi_cauhoi_tuluan';
    protected $fillable = ['maDe','maCauHoi','maPATL'];

    
}
