<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuong_cauhoi extends Model
{
    use HasFactory;
    protected $table='chuong_cauhoi';
    protected $fillable=['maChuong','maCauHoi','isdelete'];

    public function chuong()
    {
        return $this->hasMany('App\Models\chuong', 'id_chuong', 'id');
    }
}
