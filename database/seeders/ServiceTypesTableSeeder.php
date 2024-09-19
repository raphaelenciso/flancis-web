<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypesTableSeeder extends Seeder {
  public function run() {
    DB::table('service_types_tbl')->insert([
      [
        'service_type_id' => '12d8ce6fba600710',
        'service_type' => 'Hand Care',
        'service_image' => 'images/service-types/1726672956_handcare.jpg',
        'status' => 'active',
        'created_at' => '2024-09-18 07:22:36',
        'updated_at' => '2024-09-18 07:22:36'
      ],
      [
        'service_type_id' => '35e1a01f9f256fc8',
        'service_type' => 'Foot Care',
        'service_image' => 'images/service-types/1726672967_footcare.jpg',
        'status' => 'active',
        'created_at' => '2024-09-18 07:22:47',
        'updated_at' => '2024-09-18 07:22:47'
      ],
      [
        'service_type_id' => '7c3c1123192ec492',
        'service_type' => 'Body Massage',
        'service_image' => 'images/service-types/1726672979_massage.jpg',
        'status' => 'active',
        'created_at' => '2024-09-18 07:22:59',
        'updated_at' => '2024-09-18 07:22:59'
      ]
    ]);
  }
}
