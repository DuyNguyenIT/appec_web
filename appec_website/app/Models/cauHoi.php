<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cauHoi extends Model
{
    use HasFactory;

    protected $table='cau_hoi';
    protected $primaryKey='maCauHoi';
    
    protected $fillable=['noiDungCauHoi','diemCauHoi','maKQHT','maLoaiHTDG','isdelete'];
}
