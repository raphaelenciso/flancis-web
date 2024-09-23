<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model {
  use HasFactory;

  protected $table = 'appointments_tbl';
  protected $primaryKey = 'appointment_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'user_id',
    'appointment_date',
    'appointment_time',
    'service_id',
    'payment_type',
    'remarks',
    'status',
    'admin_note',
    'is_rated',
    'proof',
    'price',
    'promo_id',
    'notified1h',
    'notified1d',
  ];

  protected $casts = [
    'appointment_date' => 'date',
    'appointment_time' => 'datetime',
    'is_rated' => 'boolean',
    'price' => 'decimal:2',
    'notified1h' => 'boolean',
    'notified1d' => 'boolean',
  ];

  public function user() {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }

  public function service() {
    return $this->belongsTo(Service::class, 'service_id', 'service_id');
  }

  public function serviceRating() {
    return $this->hasOne(ServiceRating::class, 'appointment_id', 'appointment_id');
  }

  public function promo() {
    return $this->belongsTo(Promo::class, 'promo_id', 'promo_id');
  }

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->appointment_id = Str::random(16);
    });
  }
}
