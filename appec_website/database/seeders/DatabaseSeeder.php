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
            users_Seeder::class,
            giang_vien_Seeder::class,
            nganh_Seeder::class,
            bac_dao_tao_Seeder::class,
            c_nganh_Seeder::class,
            he_Seeder::class,
            loai_hoc_phan_Seeder::class,
            khoi_kien_thuc_Seeder::class,
            ct_khoi_kien_thuc_Seeder::class,
            hoc_phan_Seeder::class,
            mon_tien_quyet_Seeder::class,
            ct_dao_tao_Seeder::class,
            hoc_phan_ct_dao_tao_Seeder::class,
            cdr1_Seeder::class,
            cdr2_Seeder::class,
            cdr3_Seeder::class,
            kqht_Seeder::class,
            lop_Seeder::class,
            giang_day_Seeder::class,
            loai_danh_gia_Seeder::class,
            loai_ht_danh_gia_Seeder::class,
            hoc_phan_kqht_Seeder::class,
            hocphan_loai_ht_danh_gia_Seeder::class,
            kqht_hp_cdrcd3_Seeder::class,
            sinh_vien_Seeder::class
            

        ]);
    }
}
