<?php

namespace App\Models;

use App\Models\kqHTHP;
use App\Models\phuongAnTracNghiem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cauHoi extends Model
{
    use HasFactory;

    protected $table='cau_hoi';
    protected $primaryKey='maCauHoi';
    protected $fillable=['noiDungCauHoi','diemCauHoi','maKQHT','maLoaiHTDG','isdelete','id_muc'];

    public function phuong_an_trac_nghiem()
    {
        return $this->hasMany(phuongAnTracNghiem::class, 'maCauHoi', 'maCauHoi');
    }
    public function kqht()
    {
        return $this->belongsTo(kqHTHP::class, 'maKQHT', 'maKQHT');
    }
}
