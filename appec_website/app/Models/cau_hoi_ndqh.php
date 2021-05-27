<?php

namespace App\Models;

use App\Models\cauHoi;
use App\Models\noiDungQH;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cau_hoi_ndqh extends Model
{
    use HasFactory;
    protected $table = 'cau_hoi_ndqh';
    protected $fillable = ['maCauHoi','maNoiDungQH','created_at','updated_at'];

    public function cau_hoi()
    {
        return $this->hasOne(cauHoi::class, 'maCauHoi', 'maCauHoi');
    }

    public function noi_dung_quy_hoach()
    {
       return $this->hasOne(noiDungQH::class, 'maNoiDungQH', 'maNoiDungQH');
    }
    
}
