<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phuongAnTuLuan extends Model
{
    use HasFactory;
    protected $table = 'phuong_an_tu_luan';
    protected $fillable = ['noiDungPA','diemPA','maCDR3','maChuanAbet'];
}
