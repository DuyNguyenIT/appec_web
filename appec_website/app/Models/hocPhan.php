<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan extends Model
{
    use HasFactory;
    protected $table='hoc_phan';
    protected $primaryKey='maHocPhan';
    public $incrementing=false;
    public $fillable=['maHocPhan','tenHocPhan','tongSoTinChi','tinChiLyThuyet','tinChiThucHanh','moTaHocPhan','dacTrung','isDelete','trangThai','maCTKhoiKT'];
}
