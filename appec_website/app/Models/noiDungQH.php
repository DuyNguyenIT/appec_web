<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noiDungQH extends Model
{
    use HasFactory;
    protected $table='noi_dung_quy_hoach';
    protected $primaryKey='maNoiDungQH';
    public $incrementing=false;
    protected $fillable=['maNoiDungQH','tenNoiDungQH','noiDungQH','maMucDoDG','maKQHT','maCTBaiQH','isDelete'];
}
