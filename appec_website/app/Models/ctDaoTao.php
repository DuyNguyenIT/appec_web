<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctDaoTao extends Model
{
    use HasFactory;
    protected $table='ct_dao_tao';
    protected $primaryKey='maCT';
    public $incrementing=false;
    protected $fillable = ['maCT','tenCT','maBac','maCNganh','maHe','isDelete'];
    public function bac()
    {
        return $this->hasOne('App\Models\bacDaoTao', 'maBac', 'maBac');
    }

    public function cnganh()
    {
        return $this->hasOne('App\Models\cNganh', 'maCNganh', 'maCNganh');
    }

    public function he()
    {
        return $this->hasOne('App\Models\he', 'maHe', 'maHe');
    }
}
