<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ct_khoi_kien_thuc extends Model
{
    use HasFactory;
    protected $table='ct_khoi_kien_thuc';
    protected $primaryKey='maCTKhoiKT';
    public $incrementing=false;
    public $fillable=['maCTKhoiKT','tenCTKhoiKT','tongTinChiLT','tongTinChiTH','isDelete','maKhoiKT'];


}
