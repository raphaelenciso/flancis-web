<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentsTableSeeder extends Seeder {
  public function run() {
    DB::table('appointments_tbl')->insert([
      'appointment_id' => 'db07ad93b8038096',
      'user_id' => 'b86943b85e58988a',
      'appointment_date' => '2024-09-10',
      'appointment_time' => '11:30:00',
      'service_id' => '2a374422d2f66bac',
      'payment_type' => 'gcash',
      'remarks' => 'Nail Art',
      'status' => 'completed',
      'admin_note' => null,
      'price' => 150.00,
      'promo_id' => null,
      'is_rated' => 1,
      'proof' => 'images/appointment-proofs/1726673138_e79dd102b35213f815291e0fb4bd12df.jpg',
      'created_at' => '2024-09-18 07:25:38',
      'updated_at' => '2024-09-18 07:27:43'
    ]);
  }
}
