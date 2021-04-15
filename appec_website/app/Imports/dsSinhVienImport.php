<?php

namespace App\Imports;

use App\Models\sinhVien;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class dsSinhVienImport implements ToModel,WithHeadingRow
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new sinhVien([
            'maSSV'=>$row['massv'],
            'HoSV'=>$row['hosv'],
            'TenSV'=>$row['tensv'],
            'Phai'=>$row['phai'],
            'NgaySinh'=>$row['ngaysinh'],
            'maLop'=>$row['malop'],
           'isDelete'=>false
        ]);
    }
}
