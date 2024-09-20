<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    $this->call([
      UsersTableSeeder::class,
      ServiceTypesTableSeeder::class,
      ServicesTableSeeder::class,
      AppointmentsTableSeeder::class,
      ServiceRatingsTableSeeder::class,
      ResourcesTableSeeder::class,
      EmployeesTableSeeder::class,
      PromosTableSeeder::class,
    ]);
  }
}
