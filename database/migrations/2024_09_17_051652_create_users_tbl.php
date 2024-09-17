<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('users_tbl', function (Blueprint $table) {
      $table->string('user_id', 16)->primary();
      $table->string('username', 36);
      $table->string('first_name', 100);
      $table->string('middle_name', 100)->nullable();
      $table->string('last_name', 100);
      $table->string('gender', 16);
      $table->string('email', 36);
      $table->string('phone', 11);
      $table->date('birthday');
      $table->string('address', 100);
      $table->string('password', 255);
      $table->string('picture', 100)->nullable();
      $table->string('role', 36)->default('customer');

      $table->timestamps();
    });

    // Generate hex string for user_id
    DB::statement('ALTER TABLE users_tbl MODIFY user_id CHAR(16) NOT NULL DEFAULT (SUBSTRING(MD5(RAND()) FROM 1 FOR 16))');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('users_tbl');
  }
};
