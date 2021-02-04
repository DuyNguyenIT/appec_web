<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
               
                'maCTKhoiKT'=>'A4',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'220092',
                'tenHocPhan'=>'Nhập môn Công nghệ thông tin',
                'tongSoTinChi'=>'2',
                'tinChiLyThuyet'=>'1',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Học phần giúp trang bị cho sinh viên các kiến thức cơ bản về ngành CNTT, trình bày được những lĩnh vực ứng dụng cơ bản của CNTT trong cuộc sống, những phẩm chất, kỹ năng, kiến thức mà những người làm trong lĩnh vực CNTT cần có, Lập trình được một ứng dụng cơ bản thông qua ngôn ngữ lập trình trực quan Alice và Scratch. Đồng thời học phần cũng nhằm rèn luyện cho sinh viên các kỹ năng làm việc nhóm và kỹ năng thuyết trình. Học phần cũng giúp hình thành cho sinh viên thái độ và nhận thức đúng đắn về ngành CNTT và kỹ năng làm việc nhóm và kỹ năng thuyết trình',
               
                'maCTKhoiKT'=>'A4',
                'dacTrung'=>0
            ],


            [
                'maHocPhan'=>'220228',
                'tenHocPhan'=>'Kỹ thuật lập trình',
                'tongSoTinChi'=>'4',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'2',
                'moTaHocPhan'=>'Học phần giúp trang bị cho sinh viên các kiến thức cơ bản về kỹ thuật lập trình giải quyết bài toán trên máy tính. Đồng thời học phần cũng nhằm rèn luyện cho sinh viên các kỹ năng phân tích bài toán, lập trình giải các bài toán trên máy tính bằng ngôn ngữ lập trình C với giải thuật hiệu quả. Học phần cũng giúp hình thành cho sinh viên thái độ và nhận thức đúng đắn về tầm quan trọng của học phần và phương pháp lập trình trên máy tính.',
              
                'maCTKhoiKT'=>'B1',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'180001',
                'tenHocPhan'=>'Tư tưởng Hồ Chí Minh',
                'tongSoTinChi'=>'2',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'0',
                'moTaHocPhan'=>'',
                
                'maCTKhoiKT'=>'A1',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'190001',
                'tenHocPhan'=>'Giáo dục thể chất 2',
                'tongSoTinChi'=>'1',
                'tinChiLyThuyet'=>'0',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'',
                
                'maCTKhoiKT'=>'A5',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'220094',
                'tenHocPhan'=>'Thiết kế và lập trình web',
                'tongSoTinChi'=>'3',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Sinh viên sẽ được trang bị các kiến thức về HTML, CSS, JavaScript, lập trình hướng đối tượng trong JavaScript; JavaScript Framwork; MySQL và PHP.',
                
                'maCTKhoiKT'=>'B2',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'220055',
                'tenHocPhan'=>'Công nghệ phần mềm',
                'tongSoTinChi'=>'3',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Cung cấp cho sinh viên kiến thức tổng quan về công nghệ phần mềm, vận dụng các bước để xây dựng phần mềm (khảo sát hiện trạng, phân tích yêu cầu, thiết kế cơ sở dữ liệu, thiết kế giao diện, thiết kế xử lý, kiểm chứng, triển khai, bảo trì...). Trong quá trình học, sinh viên sẽ được giới thiệu nhiều phương pháp khác nhau để có được cái nhìn tổng quan về các phương pháp và phương pháp chủ đạo được sử dụng để minh họa là phương pháp hướng đối tượng.',
                'maCTKhoiKT'=>'B1',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'220103',
                'tenHocPhan'=>'Phân tích và thiết kế HTTT',
                'tongSoTinChi'=>'3',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'Cung cấp phương pháp luận để phân tích thiết kế một hệ thống thông tin (HTTT). Môn học chỉ giới hạn trong 2 thành phần quan trọng nhất của một HTTT, đó là các thành phần dữ liệu (khía cạnh tĩnh của HTTT) và xử lý (khía cạnh động của HTTT). Đối với thành phần dữ liệu, do đã được học trong môn cơ sở dữ liệu nên môn học này chỉ đề cập đến một cách tiếp cận khác về dữ liệu ở mức quan niệm. Các vấn đề đặt ra cho công việc phân tích thiết kế thành phần xử lý được trình bày đầy đủ. Kiến thức sẽ được vận dụng ngay vào các bài tập nghiên cứu tình huống, và cuối cùng một đồ án môn học dựa trên một bài toán thực tế sẽ phải được thực hiện theo nhóm 2 sinh viên, đi từ phân tích đến cài đặt cụ thể với một phần mềm quản trị cơ sở dữ liệu. Một số công cụ hỗ trợ phân tích thiết kế sẽ được đưa vào áp dụng cho các bài tập và đồ án môn học.',
                'maCTKhoiKT'=>'B2',
                'dacTrung'=>0
            ],
            [
                'maHocPhan'=>'220104',
                'tenHocPhan'=>'Đồ án cơ sở ngành',
                'tongSoTinChi'=>'3',
                'tinChiLyThuyet'=>'2',
                'tinChiThucHanh'=>'1',
                'moTaHocPhan'=>'',
                'maCTKhoiKT'=>'B2',
                'dacTrung'=>1
            ]
           
         ]);
    }
}
