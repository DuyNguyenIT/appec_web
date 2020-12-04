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

        ]);
    }
}
