<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class c_nganh_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('c_nganh')->insert([
            ['maCNganh'=>'1','tenCNganh'=>'Công nghệ thông tin (cử nhân – 7HK)','maNganh'=>'7480201'],
            ['maCNganh'=>'2','tenCNganh'=>'7480201','maNganh'=>'7480201'],
            ['maCNganh'=>'3','tenCNganh'=>'Hệ thống thông tin quản lý (kỹ sư – 8HK)','maNganh'=>'7480201'],
            ['maCNganh'=>'4','tenCNganh'=>'Quản trị mạng (kỹ sư – 8HK)','maNganh'=>'7480201'],
            ['maCNganh'=>'5','tenCNganh'=>'Công nghệ kỹ thuật công trình xây dựng (kỹ sư – 9HK)','maNganh'=>'7510102'],
            ['maCNganh'=>'6','tenCNganh'=>'Kỹ thuật xây dựng công trình giao thông (kỹ sư – 9HK)','maNganh'=>'7580205'],
            ['maCNganh'=>'7','tenCNganh'=>'Công nghệ kỹ thuật điện, điện tử (kỹ sư – 8HK)','maNganh'=>'7510301'],
            ['maCNganh'=>'8','tenCNganh'=>'Hệ thống điện (kỹ sư – 8HK)','maNganh'=>'7510301'],
            ['maCNganh'=>'9','tenCNganh'=>'Tự động hóa (kỹ sư – 8HK)','maNganh'=>'7510303'],
            ['maCNganh'=>'10','tenCNganh'=>'Cơ điện tử (kỹ sư – 8HK)','maNganh'=>'7510201'],
            ['maCNganh'=>'11','tenCNganh'=>'ng công trình giao thông','maNganh'=>'7510201'],
            ['maCNganh'=>'12','tenCNganh'=>'uật điện – điện tử','maNganh'=>'7510205'],
         ]);
    }
}
