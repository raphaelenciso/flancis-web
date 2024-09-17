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
    Schema::create('appointments_tbl', function (Blueprint $table) {
      $table->string('appointment_id', 36)->primary();
      $table->string('user_id', 36);
      $table->date('appointment_date');
      $table->time('appointment_time');
      $table->string('service_id', 36);
      $table->string('payment_type', 36);
      $table->text('remarks')->nullable();
      $table->string('status', 20)->default('pending');
      $table->text('admin_note')->nullable();
      $table->boolean('is_rated')->default(false);
      $table->string('proof', 100);
      $table->timestamps();

      $table->foreign('user_id')->references('user_id')->on('users_tbl')->onDelete('cascade');
      $table->foreign('service_id')->references('service_id')->on('services_tbl')->onDelete('cascade');
    });

    DB::statement('ALTER TABLE appointments_tbl MODIFY appointment_id CHAR(16) NOT NULL DEFAULT (SUBSTRING(MD5(RAND()) FROM 1 FOR 16))');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('appointments_tbl');
  }
};
