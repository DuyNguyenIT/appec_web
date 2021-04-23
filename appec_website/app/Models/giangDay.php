<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CompositeKeyModelHelper;

class giangDay extends Model
{
    use HasFactory;
    protected $table='giangday';
    public $fillable=['maHocPhan','maLop','maGV','maHK','namHoc','maBaiQH','maCDR3'];
    
}
