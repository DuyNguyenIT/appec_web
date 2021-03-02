<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class muc extends Model
{
    use HasFactory;
    protected $table = 'muc';
    protected $fillable = ['maMucVB','tenMuc','id_chuong'];
}
