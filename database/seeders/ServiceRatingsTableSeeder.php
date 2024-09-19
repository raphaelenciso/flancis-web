<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceRatingsTableSeeder extends Seeder {
  public function run() {
    DB::table('service_ratings_tbl')->insert([
      'rating_id' => 'dd2bcf9a24a4591d',
      'appointment_id' => 'db07ad93b8038096',
      'user_id' => 'b86943b85e58988a',
      'service_id' => '2a374422d2f66bac',
      'rating' => 4,
      'description' => 'Good',
      'created_at' => '2024-09-18 07:27:43',
      'updated_at' => '2024-09-18 07:27:43'
    ]);
  }
}
