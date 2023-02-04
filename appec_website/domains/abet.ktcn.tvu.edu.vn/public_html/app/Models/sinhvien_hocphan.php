<?php

namespace App\Models;

use App\Models\sinhVien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sinhvien_hocphan extends Model
{
    use HasFactory;
    protected $table = 'sinhvien_hocphan';

    protected $fillable = ['maHocPhan','maLop','maHK','namHoc','maSSV','created_at'];

    public function sinhvien()
    {
        return $this->hasOne(sinhVien::class, 'maSSV', 'maSSV');
    }

    //----------function------------------------
    public static function get_list_sv($maHocPhan,$maLop,$maHK,$namHoc)
    {
        return self::where('maHocPhan',$maHocPhan)->where('maLop',$maLop)
        ->where('maHK',$maHK)->where('namHoc',$namHoc)->with('sinhvien')->get();
    }
}
