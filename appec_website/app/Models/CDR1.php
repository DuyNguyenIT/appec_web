<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDR1 extends Model
{
    use HasFactory;
    protected $table='cdr_cd1';
    protected $primaryKey='maCDR1';
    public $incrementing=false;

    protected $fillable=['maCDR1VB','tenCDR1','isDelete'];
}
