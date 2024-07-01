<?php

namespace Database\Seeders\admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        DB::table('promotions')->insert([
            ['duration' => '24:00:00', 'price' => 2.99, 'title' => '24 ore di sponsorizzazione'],
            ['duration' => '72:00:00', 'price' => 5.99, 'title' => '72 ore di sponsorizzazione'],
            ['duration' => '144:00:00', 'price' => 9.99, 'title' => '144 ore di sponsorizzazione'],
        ]);
    }
}
