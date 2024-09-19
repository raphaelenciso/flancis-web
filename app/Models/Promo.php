<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model {
  use HasFactory;

  protected $table = 'promos_tbl';
  protected $primaryKey = 'promo_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'promo_id',
    'promo_name',
    'image',
    'percent_discount',
    'start_date',
    'end_date',
  ];

  protected $casts = [
    'percent_discount' => 'decimal:2',
    'start_date' => 'date',
    'end_date' => 'date',
  ];

  public function services() {
    return $this->belongsToMany(Service::class, 'promo_service_tbl', 'promo_id', 'service_id');
  }
}
