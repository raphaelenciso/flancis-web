<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceType extends Model {
  use HasFactory;

  protected $table = 'service_types_tbl';
  protected $primaryKey = 'service_type_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'service_type',
    'service_image',
    'status',
  ];

  public function services() {
    return $this->hasMany(Service::class, 'service_type_id', 'service_type_id');
  }

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->service_type_id = Str::random(16);
    });
  }
}
