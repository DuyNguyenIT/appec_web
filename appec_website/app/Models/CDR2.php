<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDR2 extends Model
{
    use HasFactory;
    protected $table='cdr_cd2';
    protected $primaryKey='maCDR2';
    protected $fillable=['maCDR2VB','tenCDR2','maCDR1','isDelete'];
}
