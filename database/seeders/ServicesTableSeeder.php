<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder {
  public function run() {
    DB::table('services_tbl')->insert([
      [
        'service_id' => '2a374422d2f66bac',
        'service_name' => 'Manicure',
        'service_type_id' => '12d8ce6fba600710',
        'price' => 150.00,
        'rating' => null,
        'description' => null,
        'status' => 'active',
        'created_at' => '2024-09-18 07:23:09',
        'updated_at' => '2024-09-18 07:23:09'
      ],
      [
        'service_id' => 'b97c3c4d4b3ef1e3',
        'service_name' => 'Back Massage',
        'service_type_id' => '7c3c1123192ec492',
        'price' => 500.00,
        'rating' => null,
        'description' => 'Back massage',
        'status' => 'active',
        'created_at' => '2024-09-18 07:23:34',
        'updated_at' => '2024-09-18 07:23:52'
      ],
      [
        'service_id' => 'fbecaf134a5eafad',
        'service_name' => 'Pedicure',
        'service_type_id' => '35e1a01f9f256fc8',
        'price' => 250.00,
        'rating' => null,
        'description' => null,
        'status' => 'active',
        'created_at' => '2024-09-18 07:23:17',
        'updated_at' => '2024-09-18 07:23:22'
      ]
    ]);
  }
}
