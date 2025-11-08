<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BusinessPartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_partners')->insert([
            [
                'name' => '株式会社アーシャルデザイン',
                'type' => 'customer',
                'billing_postal' => '160-0022',
                'billing_address' => '東京都新宿区新宿1-1-1',
                'email' => 'info@arshel.co.jp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '株式会社サプライヤーズ',
                'type' => 'supplier',
                'billing_postal' => '150-0001',
                'billing_address' => '東京都渋谷区神宮前2-2-2',
                'email' => 'contact@supplier.jp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
