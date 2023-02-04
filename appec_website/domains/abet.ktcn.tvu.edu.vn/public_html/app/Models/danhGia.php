<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhGia extends Model
{
    use HasFactory;
    protected $table='danh_gia';
    protected $primaryKey = 'maDanhGia';
    public $incrementing = false;
    protected $fillable = ['maDanhGia','maTCCD','diemDG','lanDG','maPhieuCham'];
    
}
