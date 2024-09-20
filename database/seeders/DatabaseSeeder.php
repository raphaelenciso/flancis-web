<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    $this->call([
      UsersTableSeeder::class,
      ServiceTypesTableSeeder::class,
      ServicesTableSeeder::class,
      PromosTableSeeder::class,
      AppointmentsTableSeeder::class,
      ServiceRatingsTableSeeder::class,
      ResourcesTableSeeder::class,
      EmployeesTableSeeder::class,
    ]);
  }
}
