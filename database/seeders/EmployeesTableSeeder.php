<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder {
  public function run() {
    DB::table('employees_tbl')->insert([
      'employee_id' => '70aedb6e43e856ce',
      'employee_first_name' => 'Mary Loi',
      'employee_last_name' => 'Ricalde',
      'employee_middle_name' => 'Yves',
      'gender' => 'female',
      'email' => 'maloi@bini.com',
      'phone' => '09987654321',
      'address' => '123 sample address street sampaloc manila',
      'birthday' => '1995-01-01',
      'role' => 'Manicurist',
      'employee_image' => 'maloi@bini.com.jpg',
      'created_at' => '2024-09-18 07:31:09',
      'updated_at' => '2024-09-18 07:31:09'
    ]);
  }
}
