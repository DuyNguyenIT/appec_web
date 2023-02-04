<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phanBoNoiDung extends Model
{
    use HasFactory;
    protected $table='phan_bo_noi_dung';
    protected $primaryKey='maPhanBoND';

    public $fillable=['maDe','maKQHT','soCauHoi','diemNhomKQHT'];

    /**
     * Get the user associated with the phanBoNoiDung
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kqht()
    {
        return $this->hasOne('App\Models\kqHTHP', 'maKQHT', 'maKQHT');
    }
}
