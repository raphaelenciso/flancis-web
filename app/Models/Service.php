<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
  use HasFactory;

  protected $table = 'services_tbl';
  protected $primaryKey = 'service_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'service_name',
    'service_type_id',
    'price',
    'rating',
    'description',
    'status',
  ];

  protected $casts = [
    'price' => 'decimal:2',
    'rating' => 'decimal:2',
  ];

  public function serviceType() {
    return $this->belongsTo(ServiceType::class, 'service_type_id', 'service_type_id');
  }

  public function appointments() {
    return $this->hasMany(Appointment::class, 'service_id', 'service_id');
  }

  public function serviceRatings() {
    return $this->hasMany(ServiceRating::class, 'service_id', 'service_id');
  }

  // Add this new relationship
  public function promos() {
    return $this->belongsToMany(Promo::class, 'promo_service_tbl', 'service_id', 'promo_id');
  }
}
