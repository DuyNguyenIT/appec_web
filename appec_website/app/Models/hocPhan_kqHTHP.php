<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_kqHTHP extends Model
{
    use HasFactory;
    protected $table='hocphan_kqht_hp';
    public $fillable=['maHocPhan','maKQHT','maCDR3','isDelete'];
}
