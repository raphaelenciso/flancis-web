<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceRating extends Model {
  use HasFactory;

  protected $table = 'service_ratings_tbl';
  protected $primaryKey = 'rating_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'appointment_id',
    'user_id',
    'service_id',
    'rating',
    'description',
  ];

  public function appointment() {
    return $this->belongsTo(Appointment::class, 'appointment_id', 'appointment_id');
  }

  public function user() {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }

  public function service() {
    return $this->belongsTo(Service::class, 'service_id', 'service_id');
  }

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->rating_id = Str::random(16);
    });
  }
}
