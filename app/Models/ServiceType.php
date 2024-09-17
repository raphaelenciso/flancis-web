<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
