<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deThi_cauHoi extends Model
{
    use HasFactory;
    protected $table='de_thi_cau_hoi';

    protected $fillable = ['maCauHoi','maDe','diem'];
}
