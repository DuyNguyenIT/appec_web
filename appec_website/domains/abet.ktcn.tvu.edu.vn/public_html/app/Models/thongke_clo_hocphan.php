<?php

namespace App\Models;

use App\Models\kqHTHP;
use App\Models\ct_bai_quy_hoach;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class thongke_clo_hocphan extends Model
{
    use HasFactory;
    protected $table = 'thongke_clo_hocphan';

    protected $fillable = ['maCTBaiQH','maKQHT','maCanBo','dat_A','dat_B','dat_C','dat_D','chua_dat','created_at','updated_at'];
    
    public function ct_bai_quy_hoach()
    {
        return $this->belongsTo(ct_bai_quy_hoach::class, 'maCTBaiQH', 'maCTBaiQH');
    }

    public function kqht()
    {
        return $this->belongsTo(kqHTHP::class, 'maKQHT', 'maKQHT');
    }
}
