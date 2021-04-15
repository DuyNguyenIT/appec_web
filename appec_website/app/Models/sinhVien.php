<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sinhVien extends Model
{
    use HasFactory;
    protected $table='sinh_vien';
    protected $fillable = ['maSSV','HoSV','TenSV','Phai','NgaySinh','maLop'];
}
