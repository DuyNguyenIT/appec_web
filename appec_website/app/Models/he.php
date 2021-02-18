<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class he extends Model
{
    use HasFactory;
    protected $table='he';
    public $incrementing=false;
    protected $primaryKey='maHe';
    protected $fillable = ['maHe','tenHe','isDelete'];
}
