<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kqHTHP extends Model
{
    use HasFactory;
    protected $table='kqht_hp';
    protected $primaryKey='maKQHT';
    public $fillable=['maKQHTVB','tenKQHT'];
}
