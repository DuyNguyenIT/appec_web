<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class hoc_phan_kqht_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocphan_kqht_hp')->insert([
            ['maHocPhan'=>'220228','maKQHT'=>'1','maCDR3'=>'1'],
            ['maHocPhan'=>'220228','maKQHT'=>'1','maCDR3'=>'2'],
            ['maHocPhan'=>'220228','maKQHT'=>'1','maCDR3'=>'3'],
            ['maHocPhan'=>'220228','maKQHT'=>'1','maCDR3'=>'4'],

            ['maHocPhan'=>'220228','maKQHT'=>'2','maCDR3'=>'1'],
            ['maHocPhan'=>'220228','maKQHT'=>'2','maCDR3'=>'2'],
            ['maHocPhan'=>'220228','maKQHT'=>'2','maCDR3'=>'3'],
            ['maHocPhan'=>'220228','maKQHT'=>'2','maCDR3'=>'4'],


            ['maHocPhan'=>'220228','maKQHT'=>'3','maCDR3'=>'1'],
            ['maHocPhan'=>'220228','maKQHT'=>'3','maCDR3'=>'2'],
            ['maHocPhan'=>'220228','maKQHT'=>'3','maCDR3'=>'3'],
            ['maHocPhan'=>'220228','maKQHT'=>'3','maCDR3'=>'4'],

            ['maHocPhan'=>'220228','maKQHT'=>'4','maCDR3'=>'1'],
            ['maHocPhan'=>'220228','maKQHT'=>'4','maCDR3'=>'2'],
            ['maHocPhan'=>'220228','maKQHT'=>'4','maCDR3'=>'3'],
            ['maHocPhan'=>'220228','maKQHT'=>'4','maCDR3'=>'4'],
         ]);
    }
}
