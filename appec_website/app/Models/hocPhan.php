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

    ##-------------function
    public static function getHocPhanByMaHocPhan($maHocPhan)
    {
        return self::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();
    }

    public static function get_cdr_by_maHocPhan($maHocPhan)
    {
        $cdr=self::where('hoc_phan.maHocPhan',$maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
        return $cdr;
    }

    public static function get_muc_by_maHocPhan($maHocPhan)
    {
        $muc=self::where('hoc_phan.maHocPhan',$maHocPhan)
        ->join('chuong',function($x){
            $x->on('chuong.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('chuong.isDelete',false);
        })
        ->join('muc',function($y){
            $y->on('muc.id_chuong','=','chuong.id')
            ->orderBy('muc.id','desc');
        })
        ->get(['muc.id','muc.maMucVB','muc.tenMuc']);
        return $muc;
    }
}
