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
    Schema::create('promos_tbl', function (Blueprint $table) {
      $table->string('promo_id', 16)->primary();
      $table->string('promo_name');
      $table->string('image')->nullable();
      $table->decimal('percent_discount', 5, 2);
      $table->date('start_date');
      $table->date('end_date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('promos_tbl');
  }
};
