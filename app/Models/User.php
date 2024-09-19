<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'users_tbl';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'user_id';

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The "type" of the auto-incrementing ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'username',
    'first_name',
    'middle_name',
    'last_name',
    'gender',
    'email',
    'phone',
    'birthday',
    'address',
    'password',
    'picture',
    'role',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'birthday' => 'date',
    'password' => 'hashed',
  ];

  public function notifications() {
    return $this->hasMany(Notification::class, 'user_id', 'user_id');
  }

  public function unreadNotifications() {
    return $this->notifications()->where('is_read', false);
  }
}
