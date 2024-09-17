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
    Schema::create('service_types_tbl', function (Blueprint $table) {
      $table->string('service_type_id', 36)->primary();
      $table->string('service_type', 36);
      $table->string('service_image', 255);
      $table->enum('status', ['active', 'inactive'])->default('active');
      $table->timestamps();
    });

    DB::statement('ALTER TABLE service_types_tbl MODIFY service_type_id CHAR(16) NOT NULL DEFAULT (SUBSTRING(MD5(RAND()) FROM 1 FOR 16))');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('service_types_tbl');
  }
};
