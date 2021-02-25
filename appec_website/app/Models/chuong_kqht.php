<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuong_kqht extends Model
{
    use HasFactory;
    protected $table='chuong_kqht';
    public $fillable=['machuong','maKQHT','isdelete'];
}
