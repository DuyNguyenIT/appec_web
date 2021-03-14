<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dethi_cauhoituluan extends Model
{
    use HasFactory;
    protected $table = 'de_thi_cauhoi_tuluan';
    protected $fillable = ['maDe','maCauHoi','maPATL'];
}
