<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tieuChuanDanhGia extends Model
{
    use HasFactory;
    protected $table='tieuchuan_danhgia';
    public $primaryKey="maTCDG";
    public $fillable=['tenTCDG','diem','isDelete','maNoiDungQH'];
}
