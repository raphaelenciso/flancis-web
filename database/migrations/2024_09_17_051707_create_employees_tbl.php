<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('employees_tbl', function (Blueprint $table) {
      $table->string('employee_id', 36)->primary();
      $table->string('employee_first_name', 100);
      $table->string('employee_last_name', 100);
      $table->string('employee_middle_name', 100)->nullable();
      $table->string('gender', 30);
      $table->string('email', 100);
      $table->string('phone', 11);
      $table->string('address', 100);
      $table->date('birthday');
      $table->string('role', 20);
      $table->string('employee_image', 100)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('employees_tbl');
  }
};
