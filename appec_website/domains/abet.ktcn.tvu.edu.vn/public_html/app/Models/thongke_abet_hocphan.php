<?php

namespace App\Models;

use App\Models\thongke_abet_hocphan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class thongke_abet_hocphan extends Model
{
   
    protected $table = 'thongke_abet_hocphan';

    protected $fillable = ['maCTBaiQH',	'maChuanAbet','maCanBo','dat_A','dat_B','dat_C','dat_D','chua_dat','created_at','updated_at'];
    
}
