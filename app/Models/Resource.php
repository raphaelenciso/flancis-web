<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model {
  use HasFactory;

  protected $table = 'resources_tbl';
  protected $primaryKey = 'resource_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'resource_name',
    'quantity',
    'status',
  ];

  protected $casts = [
    'quantity' => 'integer',
    'status' => 'string',
  ];

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->resource_id = Str::random(16);
    });
  }
}
