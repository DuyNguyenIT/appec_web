<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuan_abet extends Model
{
    use HasFactory;
    protected $table = 'chuan_abet';
    protected $primaryKey = 'maChuanAbet';
    public $incrementing = false;
    protected $fillable = ['maChuanAbetVB','maChuanAbetVB','tenChuanAbet','isDelete'];
}
