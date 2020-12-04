<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class nganh_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nganh')->insert([
            ['maNganh'=>'7480201','tenNganh'=>'Công nghệ thông tin'],
            ['maNganh'=>'7510102','tenNganh'=>'Công nghệ kỹ thuật công trình xây dựng'],
            ['maNganh'=>'7580205','tenNganh'=>'Kỹ thuật xây dựng công trình giao thông'],
            ['maNganh'=>'7510301','tenNganh'=>'Công nghệ kỹ thuật điện – điện tử'],
            ['maNganh'=>'7510303','tenNganh'=>'Công nghệ kỹ thuật điều khiển và tự động hóa'],
            ['maNganh'=>'7510201','tenNganh'=>'Công nghệ kỹ thuật cơ khí'],
            ['maNganh'=>'7340405','tenNganh'=>'Hệ thống thông tin quản lý'],
            ['maNganh'=>'7510205','tenNganh'=>'Công nghệ kỹ thuật ô tô'],
         ]);
    }
}
