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
    Schema::create('resources_tbl', function (Blueprint $table) {
      $table->string('resource_id', 36)->primary();
      $table->string('resource_name', 100);
      $table->integer('quantity');
      $table->enum('status', ['available', 'unavailable'])->default('available');
      $table->timestamps();
    });

    DB::statement('ALTER TABLE resources_tbl MODIFY resource_id CHAR(16) NOT NULL DEFAULT (SUBSTRING(MD5(RAND()) FROM 1 FOR 16))');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('resources_tbl');
  }
};
