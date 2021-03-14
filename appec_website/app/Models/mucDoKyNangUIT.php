<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mucDoKyNangUIT extends Model
{
    use HasFactory;
    protected $table = 'muc_do_ky_nang_itu';

    protected $fillable = ['id_chuong','maCDR1','ky_nang','maKQHT'];
}
