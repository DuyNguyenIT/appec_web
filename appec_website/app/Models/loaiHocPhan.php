<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaiHocPhan extends Model
{
    use HasFactory;
    protected $table='loai_hoc_phan';
    protected $primaryKey='maLoaiHocPhan';
    public $incrementing=false;
}
