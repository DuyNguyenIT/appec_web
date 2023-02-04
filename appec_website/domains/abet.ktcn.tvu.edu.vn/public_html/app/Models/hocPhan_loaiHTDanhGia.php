<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_loaiHTDanhGia extends Model
{
    use HasFactory;
    protected $table='hocphan_loai_hinhthuc_dg';
    public $fillable=['maHocPhan','maLoaiDG','maLoaiHTDG','trongSo','isDelete','groupCT'];
    public function loai_danh_gia()
    {
        return $this->hasOne('App\Models\loaiDanhGia', 'maLoaiDG', 'maLoaiDG');
    }

    public function loaiHTDanhGia()
    {
        return $this->hasOne('App\Models\loaiHTDanhGia', 'maLoaiHTDG', 'maLoaiHTDG');
    }
    public function hp_loaihtdg_kqht()
    {
        return $this->hasMany(hocPhan_loaiHTDanhGia_KQHT::class, 'maHP_LHTDG', 'id');
    }
}
