<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {
  public function run() {
    DB::table('users_tbl')->insert([
      [
        'user_id' => 'b86943b85e58988a',
        'username' => 'raphaelenciso',
        'first_name' => 'Raphael',
        'middle_name' => null,
        'last_name' => 'Enciso',
        'gender' => 'male',
        'email' => 'psyruz18@gmail.com',
        'phone' => '09273707664',
        'birthday' => '2002-06-22',
        'address' => '1047 samar st. sampaloc manila',
        'password' => '$2y$12$yYxy1xH5Mlgr4iGBLTPNRuK7Zo/fl.Lto.AuP1tVT9XYG.rJ0PltO',
        'picture' => 'b86943b85e58988a.jpg',
        'role' => 'customer',
        'created_at' => '2024-09-18 07:21:42',
        'updated_at' => '2024-09-18 07:28:55'
      ],
      [
        'user_id' => 'd01943b2fe58c88a',
        'username' => 'admin',
        'first_name' => 'admin',
        'middle_name' => null,
        'last_name' => 'admin',
        'gender' => 'male',
        'email' => 'admin@gmail.com',
        'phone' => '09123456789',
        'birthday' => '2002-06-22',
        'address' => 'admin',
        'password' => '$2y$12$yYxy1xH5Mlgr4iGBLTPNRuK7Zo/fl.Lto.AuP1tVT9XYG.rJ0PltO',
        'picture' => 'b86943b85e58988a.jpg',
        'role' => 'admin',
        'created_at' => '2024-09-18 07:21:42',
        'updated_at' => '2024-09-18 07:28:55'
      ]
    ]);
  }
}
