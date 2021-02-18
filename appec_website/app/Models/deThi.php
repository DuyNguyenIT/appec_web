<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deThi extends Model
{
    use HasFactory;
    protected $table='de_thi';
    protected $primaryKey='maDe';
    public $incrementing = false;
    public $fillable=['maDeVB','soCauHoi','tenDe','thoiGian','maCTBaiQH','ghiChu','isDelete'];
}
