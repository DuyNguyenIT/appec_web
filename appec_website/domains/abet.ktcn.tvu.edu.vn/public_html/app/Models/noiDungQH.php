<?php

namespace App\Models;

use App\Models\kqHTHP;
use App\Models\mucDoDanhGia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class noiDungQH extends Model
{
    use HasFactory;
    protected $table='noi_dung_quy_hoach';
    protected $primaryKey='maNoiDungQH';
    public $incrementing=false;
    protected $fillable=['maNoiDungQH','tenNoiDungQH','noiDungQH','maMucDoDG','maKQHT','maCTBaiQH','isDelete'];
    /**
     * Get the user that owns the noiDungQH
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function muc_do_dg()
    {
        return $this->belongsTo(mucDoDanhGia::class, 'maMucDoDG', 'maMucDoDG');
    }

    public function kqht()
    {
        return $this->belongsTo(kqHTHP::class, 'maKQHT', 'maKQHT');
    }

    public function cauhoi_ndqh()
    {
        return $this->hasMany(chuong_ndqh::class, 'maNoiDungQH', 'maNoiDungQH');
    }
}
