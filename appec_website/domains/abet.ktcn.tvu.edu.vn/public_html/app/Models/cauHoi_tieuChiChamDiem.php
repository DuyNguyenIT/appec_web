<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cauHoi_tieuChiChamDiem extends Model
{
    use HasFactory;
    protected $table='cau_hoi_tcchamdiem';
    protected $fillable = ['maCauHoi','maTCCD','maTCDG','isDelete'];
}
