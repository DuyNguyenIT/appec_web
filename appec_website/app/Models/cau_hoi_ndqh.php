<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cau_hoi_ndqh extends Model
{
    use HasFactory;
    protected $table = 'cau_hoi_ndqh';
    protected $fillable = ['maCauHoi','maNoiDungQH','created_at','updated_at'];
}
