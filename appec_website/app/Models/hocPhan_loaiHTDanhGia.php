<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_loaiHTDanhGia extends Model
{
    use HasFactory;
    protected $table='hocphan_loai_hinhthuc_dg';
    public $fillable=['maHocPhan','maLoaiDG','trongSo','isDelete'];
    public function loai_danh_gia()
    {
        return $this->hasOne('App\Models\loaiDanhGia', 'maLoaiDG', 'maLoaiDG');
    }

    public function loaiHTDanhGia()
    {
        return $this->hasOne('App\Models\loaiHTDanhGia', 'maLoaiHTDG', 'maLoaiHTDG');
    }
}
