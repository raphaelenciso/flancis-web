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
      $table->string('appointment_id', 16)->primary();
      $table->string('user_id', 16);
      $table->date('appointment_date');
      $table->time('appointment_time');
      $table->string('service_id', 16);
      $table->string('payment_type', 36);
      $table->text('remarks')->nullable();
      $table->string('status', 20)->default('pending');
      $table->text('admin_note')->nullable();
      $table->boolean('is_rated')->default(false);
      $table->string('proof', 100);
      $table->decimal('price', 10, 2);
      $table->string('promo_id', 16)->nullable();
      $table->boolean('notified1h')->default(false);
      $table->boolean('notified1d')->default(false);
      $table->timestamps();

      $table->foreign('user_id')->references('user_id')->on('users_tbl')->onDelete('cascade');
      $table->foreign('service_id')->references('service_id')->on('services_tbl')->onDelete('cascade');
      $table->foreign('promo_id')->references('promo_id')->on('promos_tbl')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('appointments_tbl');
  }
};
