<?php

namespace App\Exports;

use App\Models\ctDaoTao;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ctdtExport implements FromCollection,Responsable,ShouldAutoSize,WithMapping,WithHeadings
{
    use Exportable;
    private $filename='users.xlsx';
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return ctDaoTao::with('bac')->with('cnganh')->get();
    }

    public function map($ctdt): array
    {
        return [
            $ctdt->maCT,
            $ctdt->tenCT,
            $ctdt->bac->tenBac,
            $ctdt->cnganh->tenCNganh,
            $ctdt->he->tenHe,
        ];
    }

    public function headings(): array
    {
        return [
           'Mã chương trình',
           'Tên chương trình',
           'Bậc đào tạo',
           'Ngành đào tạo',
           'Hệ đào tạo'
        ];
    }
    
}
