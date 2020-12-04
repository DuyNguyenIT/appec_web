<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class hoc_phan_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hoc_phan')->insert([
            [   
                'maHocPhan'=>'220100',
                'tenHocPhan'=>'Lý thuyết đồ thị',
                'tongSoTinChi'=>'3',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Học phần giúp trang bị cho sinh viên các kiến thức cơ bản về toán học ứng dụng trong tin học. Đồng thời học phần cũng nhằm rèn luyện cho sinh viên kỹ năng lập trình các bài toán về lý thuyết đồ thị. Học phần cũng giúp hình thành cho sinh viên thái độ và nhận thức đúng đắn về chủ động trong học tập và kỹ năng làm việc nhóm.',
                'maLoaiHocPhan'=>'BB',
                'maCTKhoiKT'=>'A4'
            ],
            [
                'maHocPhan'=>'220092',
                'tenHocPhan'=>'Nhập môn Công nghệ thông tin',
                'tongSoTinChi'=>'2',
                'tinChiLyThuyet'=>'1',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Học phần giúp trang bị cho sinh viên các kiến thức cơ bản về ngành CNTT, trình bày được những lĩnh vực ứng dụng cơ bản của CNTT trong cuộc sống, những phẩm chất, kỹ năng, kiến thức mà những người làm trong lĩnh vực CNTT cần có, Lập trình được một ứng dụng cơ bản thông qua ngôn ngữ lập trình trực quan Alice và Scratch. Đồng thời học phần cũng nhằm rèn luyện cho sinh viên các kỹ năng làm việc nhóm và kỹ năng thuyết trình. Học phần cũng giúp hình thành cho sinh viên thái độ và nhận thức đúng đắn về ngành CNTT và kỹ năng làm việc nhóm và kỹ năng thuyết trình',
                'maLoaiHocPhan'=>'BB',
                'maCTKhoiKT'=>'A4'
            ],
           
         ]);
    }
}
