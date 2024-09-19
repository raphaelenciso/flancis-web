<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourcesTableSeeder extends Seeder {
  public function run() {
    DB::table('resources_tbl')->insert([
      'resource_id' => 'dcb2df50624b2e5e',
      'resource_name' => 'Conference Room B',
      'quantity' => 1,
      'status' => 'unavailable',
      'created_at' => '2024-09-18 07:28:20',
      'updated_at' => '2024-09-18 07:28:42'
    ]);
  }
}
