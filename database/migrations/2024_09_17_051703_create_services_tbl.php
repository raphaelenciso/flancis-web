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
    Schema::create('services_tbl', function (Blueprint $table) {
      $table->string('service_id', 16)->primary();
      $table->string('service_name', 100);
      $table->string('service_type_id', 16);
      $table->decimal('price', 10, 2);
      // $table->decimal('rating', 10, 2)->nullable();
      $table->text('description')->nullable();
      $table->enum('status', ['active', 'inactive'])->default('active');
      $table->timestamps();

      $table->foreign('service_type_id')->references('service_type_id')->on('service_types_tbl')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('services_tbl');
  }
};
