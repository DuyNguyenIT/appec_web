<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phieu_cham extends Model
{
    use HasFactory;
    protected $table='phieu_cham';
    protected $primaryKey = 'maPhieuCham';

    public $fillable=['maGV','maSSV','maDe','diaDiem','ghiChu','diemSo','diemChu','yKienDongGop','ngayCham','isDelete','trangThai','xepHang','loaiCB'];

}
