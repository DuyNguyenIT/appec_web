<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaiDanhGia extends Model
{
    use HasFactory;
    protected $table='loai_danh_gia';

    protected $primaryKey = 'maLoaiDG';
    public $incrementing = false;
    protected $fillable = ['tenLoaiDG','tenLoaiDG_EN','isDelete'];

}
