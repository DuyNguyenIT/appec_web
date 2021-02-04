<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CompositeKeyModelHelper;

class giangDay extends Model
{
    use HasFactory;
    protected $table='giangday';
    protected $primaryKey=['maHocPhan','maLop','maGV','maHK','namHoc','maBaiQH','maCDR3'];
    public $incrementing = false;
}
