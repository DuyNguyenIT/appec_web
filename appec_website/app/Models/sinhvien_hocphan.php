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
}
