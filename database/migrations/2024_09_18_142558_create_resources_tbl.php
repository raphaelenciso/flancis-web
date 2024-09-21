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
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('resources_tbl');
  }
};
