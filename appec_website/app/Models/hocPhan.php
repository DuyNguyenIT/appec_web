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
    
    
    public static function getListHocPhan()
    {
        return self::where('isDelete',false)->get();
    }
    
    public function ctkhoi()
    {
        return $this->hasOne('App\Models\ctKhoiKT', 'maCTKhoiKT', 'maCTKhoiKT');
    }

    public static function getHocPhanByMaHocPhan($maHocPhan)
    {
        return self::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();
    }
}
