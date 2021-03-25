<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDR3 extends Model
{
    use HasFactory;
    protected $table='cdr_cd3';
    protected $primaryKey='maCDR3';
    protected $fillable=['maCDR3VB','tenCDR3','maCDR2','isDelete'];
}
