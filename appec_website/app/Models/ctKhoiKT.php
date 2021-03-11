<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctKhoiKT extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table='ct_khoi_kien_thuc';
    protected $primaryKey = 'maCTKhoiKT';
    protected $fillable = ['maCTKhoiKT','tenCTKhoiKT'];
    
}
