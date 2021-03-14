<?php

namespace App\Http\Controllers\Admin;

use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;

class AdWordController extends Controller
{
    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //tạo nội dung file
        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        //format table
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        
        
        $section = $phpWord->addSection();
        // Add first page header
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText('Trường Đại học Trà Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spaceAfter' => 100));

        // Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addText('Trường Đại học Trà Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'));

        // 1/ Thong tin chung
        $section->addText('Đề cương học phần',$headerForntStyle,$headerparagraphStyle);
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();  //truy vấn thông tin học phần
       
        $hoc_phan = $section->addTextRun($headerparagraphStyle);
        $hoc_phan->addText('Học phần: ',array('bold' => true, 'size' => 13,'name'=>'Times New Roman'));
        $hoc_phan->addText($hocPhan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        
        $ma_hoc_phan = $section->addTextRun($headerparagraphStyle);
        $ma_hoc_phan->addText('Mã học phần: ',array('bold' => true, 'size' => 13,'name'=>'Times New Roman'));
        $ma_hoc_phan->addText($hocPhan->maHocPhan,$headerForntStyle,$headerparagraphStyle);
        ////------------------------------------------1/ thông tin chung---------------------------------------------
        $section->addText('1. Thông tin chung',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);

        $table->addRow(); //tiêu đề bảng thông tin chung

        $cell1 = $table->addCell(4000, $cellRowSpan); 
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Loại học phần',$headding1);

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Số tín chỉ',$headding1);

        $cell3=$table->addCell(4000, $cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Số giờ học',$headding1);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Đại cương",0,$normalText);
        $cell1->addListItem("Cơ sở",0,$normalText);
        $cell1->addListItem("Chuyên ngành",0,$normalText);

        

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Lý thuyết: ".$hocPhan->tinChiLyThuyet,0,$normalText);
        $cell1->addListItem("Bài tập:",0,$normalText);
        $cell1->addListItem("Thực hành: ".$hocPhan->tinChiThucHanh,0,$normalText);

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Lý thuyết: ".($hocPhan->tinChiLyThuyet*15),0,$normalText);
        $cell1->addListItem("Bài tập:",0, $normalText);
        $cell1->addListItem("Thực hành: ".($hocPhan->tinChiThucHanh*30),0,$normalText);

        $doi_tuong_hoc=$section->addTextRun();  //đối tượng học
        $doi_tuong_hoc->addText('Đối tượng học:     ',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $doi_tuong_hoc->addText('  Bậc: Đại học',$normalText,array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('right', 9090))));
        $section->addText('Ngành:   Công nghệ thông tin ',$normalText);
        $section->addText('Hệ:         Chính quy',$normalText);
        
        $section->addText('Điều kiện tham gia môn học',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        
        
        $table = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addText('Học phần tiên quyết',$normalText);
        $cell1 = $table->addCell(8000);
        $cell1->addText('B');

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addText('Các yêu cầu khác:',$normalText);
        $cell1 = $table->addCell(8000);
        $html = $hocPhan->yeuCau;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        // //--------------------------------------2. Tài liệu tham khảo------------------------------------------------------------
      
        $section->addText('2. Tài liệu tham khảo',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $tailieuthamkhao=tai_lieu_tham_khao::where('maHocPhan',$maHocPhan)->first();

        $table_tailieuthamkhao = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_tailieuthamkhao->addRow();
        $cell1 = $table_tailieuthamkhao->addCell(4000);
        $cell1->addText('Giáo trình/ Tài liệu học tập chính',$normalText);
        $cell1 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->giaoTrinh;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        $table_tailieuthamkhao->addRow();
        $cell2 = $table_tailieuthamkhao->addCell(4000);
        $cell2->addText('Tài liệu tham khảo thêm',$normalText);
        $cell2 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->thamKhaoThem;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $html, false, false);
        
        $table_tailieuthamkhao->addRow();
        $cell3 = $table_tailieuthamkhao->addCell(4000);
        $cell3->addText('Các loại học liệu khác',$normalText);
        $cell3 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->taiLieuKhac;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell3, $html, false, false);

        //--------------------------------------3. Mô tả học phần------------------------------------------------------------
        
        $section->addText('3. Mô tả học phần',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $html = $hocPhan->moTaHocPhan;
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        //--------------------------------------4. Chuẩn đầu ra học phần------------------------------------------------------------
        $section->addText('4. Chuẩn đầu ra học phần:',$headding1);
        $section->addText('Sau khi hoàn thành học phần, sinh viên có thể:',$normalText);
        
        $table_chuandaura = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_chuandaura->addRow();
        $cell2 = $table_chuandaura->addCell(2000);
        $cell2->addText('A');
        $cell2 = $table_chuandaura->addCell(2000,array('vMerge'=>'continue'));
        $cell2 = $table_chuandaura->addCell(2000,$cellRowSpan);
        $cell2->addText('B');
        //--------------------------------------5. Nội dung học phần----------------------------------------------------------------
        $section->addText('5. Nội dung học phần:',$headding1);
        //--------------------------------------6. Phương pháp giảng dạy:-----------------------------------------------------------
        $section->addText('6. Phương pháp giảng dạy:',$headding1);
        $hp_ppgd=hocPhan_ppGiangDay::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ppGiangDay')->get(); //biển hiển thị phương pháp giảng dạy 

        $table_giangday = $section->addTable($spanTableStyleName);

        $table_giangday->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Mã số',$headding1);
        
        $cell2 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Phương pháp giảng dạy',$headding1);

        
        $cell3 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Diễn giải',$headding1);

        $i=1;
        foreach ($hp_ppgd as $x) {
            $table_giangday->addRow(); //nội dung bảng giảng dạy
            $cell1 = $table_giangday->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($i);
            
            $cell2 = $table_giangday->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($x->ppGiangDay->tenPP);
    
            
            $cell3 = $table_giangday->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($x->dienGiai);
            $i++;
        }

        //--------------------------------------7. Phương thức đánh giá:-----------------------------------------------------------
        $section->addText('7. Phương thức đánh giá:',$headding1);

        $table_phuongthucdanhgia= $section->addTable($spanTableStyleName);

        $table_phuongthucdanhgia->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Mã số',$headding1);
        
        $cell2 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Hình thức đánh giá',$headding1);

        
        $cell3 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Tỉ lệ',$headding1);
        //--------------------------------------8. Các quy định chung:-----------------------------------------------------------
        $section->addPageBreak();
        $section->addText('8. Các quy định chung:',$headding1);
        $section->addText('Các quy định về tham dự lớp học',$headding1);
        $section->addListItem('Sinh viên có trách nhiệm tham dự đầy đủ các buổi học. Trong trường hợp phải nghỉ học vì lý do bất khả kháng thì phải có giấy tờ chứng minh đầy đủ và hợp lý.',0,$normalText);
        $section->addListItem('Sinh viên vắng quá 20% số tiết của học phần, dù có lý do hay không có lý do, đều bị coi như không hoàn thành học phần và phải đăng ký học lại vào học kỳ sau.',0,$normalText);
        $section->addText('Quy định về hành vi trong lớp học',$headding1);
        $section->addListItem('Học phần được thực hiện trên nguyên tắc tôn trọng người học và người dạy. Mọi hành vi làm ảnh hưởng đến quá trình dạy và học đều bị nghiêm cấm.',0,$normalText);
        $section->addListItem('Sinh viên phải đi học đúng giờ qui định. Sinh viên đi trễ quá 5 phút sau khi giờ học bắt đầu sẽ không được tham dự buổi học.',0,$normalText);
        $section->addListItem('Tuyệt đối không làm ồn, gây ảnh hưởng đến người khác trong quá trình học.',0,$normalText);
        $section->addListItem('Tuyệt đối không được ăn, nhai kẹo cao su, sử dụng các thiết bị như điện thoại, máy nghe nhạc trong giờ học.',0,$normalText);
        $section->addListItem('Máy tính xách tay, máy tính bảng chỉ được sử dụng trên lớp với mục đích ghi chép bài giảng, tính toán phục vụ bài giảng, bài tập. Tuyệt đối không dùng vào việc khác.',0,$normalText);
        $section->addListItem('Sinh viên vi phạm các nguyên tắc trên sẽ bị mời ra khỏi lớp và bị coi là vắng buổi học đó.',0,$normalText);
        $section->addText('Quy định về học vụ',$headding1);
        $section->addListItem('Các vấn đề liên quan đến xin bảo lưu điểm, khiếu nại điểm, chấm phúc tra, kỷ luật thi cử được thực hiện theo quy chế học vụ của trường Đại học Trà Vinh.',0,$normalText);
        $filename=$hocPhan->maHocPhan.'_'.$hocPhan->tenHocPhan.'.docx';
        //xuất fileE
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }
}
