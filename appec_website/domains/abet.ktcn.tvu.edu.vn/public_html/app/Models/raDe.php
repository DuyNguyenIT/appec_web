<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raDe extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ra_de';
    protected $primaryKey = 'id_RaDe';
    protected $fillable = ['maDe','maGV','maHocPhan','maLop','lanThu'];
}