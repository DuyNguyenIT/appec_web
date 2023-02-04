<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quyHoach_hocPhan extends Model
{
    use HasFactory;
    protected $table='quyhoach_hocphan';
    protected $primaryKey='id_QH_HP';
    public $fillabel=['maHocPhan','maLoaiDG','maLoaiHTDG','maBaiQH','maGV','isDelete'];
}
