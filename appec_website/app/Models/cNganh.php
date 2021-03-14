<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cNganh extends Model
{
    use HasFactory;
    protected $table='c_nganh';
    protected $primaryKey = 'maCNganh';
    protected $fillable = ['tenCNganh','maNganh','isDelete'];
    public function nganh()
    {
        return $this->hasOne('App\Models\nganh', 'maNganh', 'maNganh');
    }
}
