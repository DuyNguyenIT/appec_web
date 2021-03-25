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
    protected $fillable = ['maHocPhan','tenHocPhan','tongSoTinChi','tinChiLyThuyet','tinChiThucHanh','moTaHocPhan','maCTKhoiKT','isDelete'];
    public function ctkhoi()
    {
        return $this->hasOne('App\Models\ctKhoiKT', 'maCTKhoiKT', 'maCTKhoiKT');
    }

}
