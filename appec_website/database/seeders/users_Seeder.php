<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class users_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['username'=>'admin','password'=>'21232f297a57a5a743894a0e4a801fc3'], //admin
            ['username'=>'ptpnam','password'=>'202cb962ac59075b964b07152d234b70'],//123
            
         ]);
    }
}
