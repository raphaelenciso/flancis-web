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
    Schema::create('service_ratings_tbl', function (Blueprint $table) {
      $table->string('rating_id', 16)->primary();
      $table->string('appointment_id', 36);
      $table->string('user_id', 16);
      $table->string('service_id', 16);
      $table->integer('rating')->check('rating >= 1 AND rating <= 5');
      $table->text('description')->nullable();
      $table->timestamps();

      $table->foreign('appointment_id')->references('appointment_id')->on('appointments_tbl')->onDelete('cascade');
      $table->foreign('user_id')->references('user_id')->on('users_tbl')->onDelete('cascade');
      $table->foreign('service_id')->references('service_id')->on('services_tbl')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('service_ratings_tbl');
  }
};
