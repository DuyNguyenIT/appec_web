<?php

namespace App\Models;

use App\Models\ctDaoTao;
use App\Models\loaiHocPhan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class hocPhan_ctDaoTao extends Model
{
    use HasFactory;
    protected $table='hocphan_ctdaotao';
    protected $fillable = ['maHocPhan','maCT','phanPhoiHocKy','isDelete','maLoaiHocPhan'];

    public function ctDaoTao()
    {
        return $this->hasMany(ctDaoTao::class, 'maCT', 'maCT');
    }

    public function loaiHocPhan()
    {
        return $this->hasMany(loaiHocPhan::class, 'maLoaiHocPhan', 'maLoaiHocPhan');
    }
   
}
