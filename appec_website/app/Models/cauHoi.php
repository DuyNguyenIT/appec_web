<?php

namespace App\Models;

use App\Models\kqHTHP;
use App\Models\deThi_cauHoi;
use App\Models\dethi_cauhoituluan;
use App\Models\phuongAnTracNghiem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cauHoi extends Model
{
    use HasFactory;

    protected $table='cau_hoi';
    protected $primaryKey='maCauHoi';
    protected $fillable=['noiDungCauHoi','diemCauHoi','maKQHT','maLoaiHTDG','isdelete','id_muc','maGV'];

    public function phuong_an_trac_nghiem()
    {
        return $this->hasMany(phuongAnTracNghiem::class, 'maCauHoi', 'maCauHoi');
    }
    public function kqht()
    {
        return $this->belongsTo(kqHTHP::class, 'maKQHT', 'maKQHT');
    }

    ##----------------function---------------------------
    public static function get_cau_hoi_by_maCH($maCauHoi)  //lấy 1 câu hỏi 
    {
        return self::where('isDelete',false)->where('maCauHoi',$maCauHoi)->first();
    }
    public static function get_cau_hoi_trac_nghiem($maHocPhan) //lay tat ca cau hoi trac nghiem trong hoc phan
    {
        $chuong=chuong::where('maHocPhan',$maHocPhan)->pluck('id');
        $muc=muc::whereIn('id_chuong',$chuong)->get('id');
        return self::where('isDelete',false)->where('maLoaiHTDG','T2')->whereIn('id_muc',$muc)->get();
    }

    public static function get_cau_hoi_trac_nghiem_by_mamuc($maMuc) //lay cau hoi trac nghiem theo muc
    {
        return self::where('isDelete',false)->where('id_muc',$maMuc)->where('maLoaiHTDG','T2')->get();
    }

    public static function get_cau_hoi_trac_nghiem_by_mamuc_distinct($maDe,$maMuc) //lay cau hoi trac nghiem khong co trong de thi
    {
        $dt_arr=deThi_cauHoi::where('maDe',$maDe)->pluck('maCauHoi');
        return self::where('isDelete',false)->where('id_muc',$maMuc)->whereNotIn('maCauHoi',$dt_arr)->where('maLoaiHTDG','T2')->get();
    }

    //xu ly cho tu luan
    public static function get_cau_hoi_tu_luan_by_mamuc_distinct($maDe,$maMuc) //ham xu ly get cau hoi tu luan (tru nhung cau hoi trong de thi)
    {
        $dt_arr=dethi_cauhoituluan::where('maDe',$maDe)->pluck('maCauHoi');
        return self::where('isDelete',false)->where('id_muc',$maMuc)->where('maLoaiHTDG','T1')->whereNotIn('maCauHoi',$dt_arr)->get();
    }

    public static function get_cau_hoi_tu_luan($maHocPhan)  //lay tat ca cau hoi tu luan trong hoc phans
    {
        $chuong=chuong::where('maHocPhan',$maHocPhan)->pluck('id');
        $muc=muc::whereIn('id_chuong',$chuong)->get('id');
        return self::where('isDelete',false)->where('maLoaiHTDG','T1')->whereIn('id_muc',$muc)->get();
    }
    //xu ly cho thuc hanh
    public static function get_cau_hoi_thuc_hanh_by_mamuc_distinct($maDe,$maMuc) //ham xu ly get cau hoi thuc hanh (tru nhung cau hoi trong de thi)
    {
        $dt_arr=dethi_cauhoituluan::where('maDe',$maDe)->pluck('maCauHoi');
        return self::where('isDelete',false)->where('id_muc',$maMuc)->where('maLoaiHTDG','T3')->whereNotIn('maCauHoi',$dt_arr)->get();
    }
    
    public static function get_cau_hoi_thuc_hanh($maHocPhan)  //lay tat ca cau hoi thuc hanh trong hoc phan
    {
        $chuong=chuong::where('maHocPhan',$maHocPhan)->pluck('id');
        $muc=muc::whereIn('id_chuong',$chuong)->get('id');
        return self::where('isDelete',false)->where('maLoaiHTDG','T3')->whereIn('id_muc',$muc)->get();
    }

}
