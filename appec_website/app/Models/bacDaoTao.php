<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bacDaoTao extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table='bac_dao_tao';
    protected $primaryKey = 'maBac';
    //PTTMai có chỉnh trong biến fillable để xử lý xóa, úp lại
    protected $fillable = ['maBac','tenBac','isDelete'];
    
}
