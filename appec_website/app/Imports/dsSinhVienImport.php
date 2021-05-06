<?php

namespace App\Imports;

use App\Models\sinhVien;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;

class dsSinhVienImport implements ToModel,WithHeadingRow
{
    use Importable;

    
    public function model(array $row)
    {
        if($row['massv']==null){
            return null;
        }
        $sv=sinhVien::where('maSSV',$row['massv'])->first();
        if($sv){
            return null;
        }else{
            return new sinhVien([
                'maSSV'=>$row['massv'],
                'HoSV'=>$row['hosv'],
                'TenSV'=>$row['tensv'],
                'Phai'=>$row['phai'],
                'NgaySinh'=>$row['ngaysinh'],
                'maLop'=>Session::get('maLop'),
               'isDelete'=>false
            ]);
        }
    }
}
