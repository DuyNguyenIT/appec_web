<?php

namespace App\Imports;

use Session;
use App\Models\sinhVien;
use App\Models\sinhvien_hocphan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class dsSV_HPImport implements ToModel,WithHeadingRow
{
    use Importable;
    public function model(array $row)
    {
        if($row['massv']==null){
            return null;
        }
        $sv=sinhVien::where('maSSV',$row['massv'])->first();
        if($sv){
            //kiem tra neu sinh vien da duoc them roi thi khong them
            $sv_hp=sinhvien_hocphan::where('maSSV',$row['massv'])->where('maHocPhan',Session::get('maHocPhan'))
            ->where('maLop',Session::get('maLop'))->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))->first();
            if($sv_hp){
                return null;
            }else{
                return new sinhvien_hocphan([
                    'maSSV'=>$row['massv'],
                    'maHocPhan'=>Session::get('maHocPhan'),
                    'maLop'=>Session::get('maLop'),
                    'maHK'=>Session::get('maHK'),
                    'namHoc'=>Session::get('namHoc'),
                    'isDelete'=>false
                ]);
            }
        }else{
            return null;
        }
    }
}
