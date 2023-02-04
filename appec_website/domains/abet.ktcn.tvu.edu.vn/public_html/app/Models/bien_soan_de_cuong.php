<?php

namespace App\Models;

use App\Models\hocPhan;
use App\Models\giangVien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bien_soan_de_cuong extends Model
{
    use HasFactory;
    protected $table = 'bien_soan_de_cuong';
    protected $fillable = ['maHocPhan','maGV','thoiGianBatDau','thoiGianKetThuc','created_at','updated_at']; 

    public function hoc_phan()
    {
        return $this->hasOne(hocPhan::class, 'maHocPhan', 'maHocPhan');
    }

    public function giang_vien()
    {
        return $this->hasOne(giangVien::class, 'maGV', 'maGV');
    }
}
