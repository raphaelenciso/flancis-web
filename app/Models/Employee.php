<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model {
  use HasFactory;

  protected $table = 'employees_tbl';
  protected $primaryKey = 'employee_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'employee_first_name',
    'employee_last_name',
    'employee_middle_name',
    'gender',
    'email',
    'phone',
    'address',
    'birthday',
    'role',
    'employee_image',
  ];

  protected $casts = [
    'birthday' => 'date',
  ];

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->employee_id = Str::random(16);
    });
  }
}
