<?php

namespace App\Models;

use App\Models\hocPhan_ctDaoTao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function hocphan_ctdt()
    {
        return $this->hasMany(hocPhan_ctDaoTao::class, 'maHocPhan', 'maHocPhan');
    }

    public static function getHocPhanByMaHocPhan($maHocPhan)
    {
        return self::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();
    }
}
