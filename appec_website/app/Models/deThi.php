<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deThi extends Model
{
    use HasFactory;
    protected $table='de_thi';
    protected $primaryKey='maDe';
    public $incrementing = false;
    public $fillable=['maDeVB','soCauHoi','tenDe','thoiGian','maCTBaiQH','ghiChu','isDelete'];

    public function de_thi_cauhoi_tuluan()
    {
        return $this->hasMany(de_thi_cauhoi_tuluan::class, 'maDe', 'maDe');
    }

    public static function getPhieuChamByCTBQH($maCTBaiQH,$maGV)
    {
        return self::where('de_thi.isDelete',false)
        ->where('de_thi.maCTBaiQH',$maCTBaiQH)
        ->Join('phieu_cham',function($x) use($maGV){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',$maGV)
            ->where('phieu_cham.isDelete',false);
        })
        ->leftJoin('sinh_vien',function($y){
            $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
            ->where('sinh_vien.isDelete',false);
        })
        //->orderBy('phieu_cham.maSSV','desc')
        ->get(['de_thi.maDeVB','de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','phieu_cham.maPhieuCham','phieu_cham.trangThai','phieu_cham.diemSo']);
    }

    public static function get_de_thi_by_made($maDe)
    {
        return self::where('isDelete',false)->where('maDe',$maDe)->first();
    }
}
