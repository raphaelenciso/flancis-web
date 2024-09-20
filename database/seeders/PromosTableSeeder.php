<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromosTableSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $promos = [
      [
        'promo_id' => 'lB2gllHhURkU247P',
        'promo_name' => 'Mother\'s Day Promo',
        'image' => 'images/promos/1726842780_10_off_promo.jpg',
        'percent_discount' => 10.00,
        'start_date' => '2024-09-23',
        'end_date' => '2024-09-30',
        'created_at' => '2024-09-20 06:33:00',
        'updated_at' => '2024-09-20 06:33:20',
      ],
      [
        'promo_id' => 'UxuZtGU7hk1xVYkT',
        'promo_name' => 'Valentine Promo',
        'image' => 'images/promos/1726842830_20_off_promo.jpg',
        'percent_discount' => 20.00,
        'start_date' => '2024-02-14',
        'end_date' => '2024-02-15',
        'created_at' => '2024-09-20 06:33:50',
        'updated_at' => '2024-09-20 06:34:08',
      ],
    ];

    foreach ($promos as $promo) {
      DB::table('promos_tbl')->insert($promo);
    }
  }
}
