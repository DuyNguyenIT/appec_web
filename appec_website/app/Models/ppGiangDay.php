<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ppGiangDay extends Model
{
    use HasFactory;
    protected $table='pp_giangday';

    protected $primaryKey = 'maPP';
    public $fillable=['tenPP','isDelete'];
}
