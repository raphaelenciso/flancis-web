<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
