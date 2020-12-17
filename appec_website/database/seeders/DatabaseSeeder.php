<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            users_Seeder::class,  //user
            giang_vien_Seeder::class,  //giảng viên
            nganh_Seeder::class,  //ngành
            bac_dao_tao_Seeder::class, //bậc đào tạo
            c_nganh_Seeder::class,  //chuyên ngành
            he_Seeder::class, //hệ
            loai_hoc_phan_Seeder::class,  //loại học phần
            khoi_kien_thuc_Seeder::class,  //khối kiến thức
            ct_khoi_kien_thuc_Seeder::class,  //chi tiết khối kiến thức
            hoc_phan_Seeder::class,  //học phần
            mon_tien_quyet_Seeder::class,  //môn tiên quyết
            ct_dao_tao_Seeder::class,  //chi tiết đào tạo
            hoc_phan_ct_dao_tao_Seeder::class,  //học phần - chương trình đào tọa
            cdr1_Seeder::class,
            cdr2_Seeder::class,
            cdr3_Seeder::class,
            kqht_Seeder::class,
            lop_Seeder::class,  //lớp
            bai_quy_hoach_Seeder::class,  //bài quy hoạch
           
            giang_day_Seeder::class,  //giảng dạy
            loai_danh_gia_Seeder::class,  //loại đánh giá
            loai_ht_danh_gia_Seeder::class,  //loại hình thức đánh giá
            hoc_phan_kqht_Seeder::class,  //học phần - kết quả học tập
            ct_bai_QH_Seeder::class,  //chi tiết bài quy hoạch
            hocphan_loai_ht_danh_gia_Seeder::class,  //học phần loại hình thức đánh giá
            sinh_vien_Seeder::class, //sinh viên
            dethi_Seeder::class,
            mucDoDG_Seeder::class,
            noiDungQH_Seeder::class,
            tieu_chuan_danh_gia_Seeder::class,
            tieu_chi_danh_gia_Seeder::class,
            cau_hoi_Seeder::class,
            cau_hoi_tieu_chi_Seeder::class

            
        ]);
    }
}
