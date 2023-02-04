<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuong_ndqh extends Model
{
    use HasFactory;
    protected $table='chuong_ndqh';
    protected $fillable=['id_chuong','maNoiDungQH','isDelete'];
}
