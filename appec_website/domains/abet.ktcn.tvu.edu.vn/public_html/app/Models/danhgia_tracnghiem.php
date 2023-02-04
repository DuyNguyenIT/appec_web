<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhgia_tracnghiem extends Model
{
    use HasFactory;
    protected $table = 'danhgia_tracnghiem';
    protected $fillable = ['maPhieuCham','maPA','diem','created_at','updated_at'];

    public function phieucham()
    {
        return $this->hasMany(phieu_cham::class, 'maPhieuCham', 'maPhieuCham');
    }

    
    

}
