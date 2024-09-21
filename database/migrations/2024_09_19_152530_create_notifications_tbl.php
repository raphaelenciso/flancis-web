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
    Schema::create('notifications_tbl', function (Blueprint $table) {
      $table->string('notification_id', 36)->primary();
      $table->string('user_id', 36);
      $table->string('title', 100);
      $table->text('message');
      $table->boolean('is_read')->default(false);
      $table->string('route')->default('#');
      $table->timestamps();

      $table->foreign('user_id')->references('user_id')->on('users_tbl')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('notifications_tbl');
  }
};
