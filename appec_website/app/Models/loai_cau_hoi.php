<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loai_cau_hoi extends Model
{
    use HasFactory;
    protected $table='loai_cau_hoi';
    public $fillable=['tenLoaiCauHoi','isdelete'];
}
