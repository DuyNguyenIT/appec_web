<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lop extends Model
{
    use HasFactory;
    protected $table='lop';
    
    protected $primaryKey = 'maLop';
    protected $fillable = ['maLop','tenLop','namTS'];
    public $incrementing = false;
}
