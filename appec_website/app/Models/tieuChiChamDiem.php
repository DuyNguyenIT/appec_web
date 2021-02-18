<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tieuChiChamDiem extends Model
{
    use HasFactory;
    protected $table='tieu_chi_cham_diem';
    protected $primaryKey='maTCCD';
    protected $fillable=['tenTCCD','diemTCCD','isDelete','maCDR3'];

}
