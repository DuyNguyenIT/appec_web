<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_loaiHTDanhGia_KQHT extends Model
{
    use HasFactory;
    protected $table = 'hocphan_loaihtdg_kqht';
    protected $fillable = ['maHP_LHTDG','maKQHT','maKQHTVB'];
}