<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class tieu_chi_danh_gia_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tieu_chi_cham_diem')->insert([
            ['maCDR3'=>'1','maTCCD'=>'1','tenTCCD'=>'Định dạng văn bản đúng quy định (font, size, khổ giấy, canh lề, văn bản, định dạng đoạn,....) ','diemTCCD'=>'0.25'],
            ['maCDR3'=>'1','maTCCD'=>'2','tenTCCD'=>'Có danh mục hình, bảng (nếu có),  danh mục từ viết tắt (nếu có)','diemTCCD'=>'0.25'],
            ['maCDR3'=>'1','maTCCD'=>'3','tenTCCD'=>'Văn phong rõ ràng, mạch lạc, không lỗi chính tả','diemTCCD'=>'0.25'],
            ['maCDR3'=>'1','maTCCD'=>'4','tenTCCD'=>'Mục lục, tài liệu tham khảo đúng quy định, kết luận','diemTCCD'=>'0.25']
         ]);
    }
}
