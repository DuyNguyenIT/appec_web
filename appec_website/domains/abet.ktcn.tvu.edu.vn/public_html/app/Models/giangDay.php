<?php

namespace App\Models;

use App\Models\giangVien;
use CompositeKeyModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class giangDay extends Model
{
    use HasFactory;
    protected $table='giangday';
    public $fillable=['maHocPhan','maLop','maGV','maHK','namHoc','maBaiQH','maCDR3','isDelete'];

    public function hocphan()
    {
        return $this->hasOne(hocphan::class, 'maHocPhan', 'maHocPhan');
    }

    public function giangvien()
    {
        return $this->hasOne(giangVien::class, 'maGV', 'maGV');
    }
    
}
