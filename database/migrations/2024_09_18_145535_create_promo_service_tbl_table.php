<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up() {
    Schema::create('promo_service_tbl', function (Blueprint $table) {

      $table->string('service_id', 16);
      $table->string('promo_id', 16);

      $table->foreign('promo_id')->references('promo_id')->on('promos_tbl')->onDelete('cascade');
      $table->foreign('service_id')->references('service_id')->on('services_tbl')->onDelete('cascade');
      $table->primary(['promo_id', 'service_id']);
    });
  }

  public function down() {
    Schema::dropIfExists('promo_service_tbl');
  }
};
