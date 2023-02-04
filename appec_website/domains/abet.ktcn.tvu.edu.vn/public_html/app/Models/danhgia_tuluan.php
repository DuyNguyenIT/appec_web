<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhgia_tuluan extends Model
{
    use HasFactory;
    protected $table = 'danhgia_tuluan';
    protected $fillable = ['maPATL','maPhieuCham','diemDG','lanDG','thuTu'];
}
