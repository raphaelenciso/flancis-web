<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model {
  use HasFactory;

  protected $table = 'notifications_tbl';
  protected $primaryKey = 'notification_id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'user_id',
    'title',
    'message',
    'is_read',
    'route',
  ];

  public function user() {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }

  protected static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->notification_id = Str::random(16);
    });
  }
}
