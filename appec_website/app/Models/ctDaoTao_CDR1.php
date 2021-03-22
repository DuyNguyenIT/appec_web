<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctDaoTao_CDR1 extends Model
{
    use HasFactory;
    protected $table='ctdt_cdrcd1';
    public $fillable=['maCT','maCDR1','isDelete'];
    
}
