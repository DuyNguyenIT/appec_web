<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tai_lieu_tham_khao extends Model
{
    use HasFactory;
    protected $table='tai_lieu_tham_khao';
    public $fillable=['giaoTrinh','thamKhaoThem','taiLieuKhac','maHocPhan'];
}
