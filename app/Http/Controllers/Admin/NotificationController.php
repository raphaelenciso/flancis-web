<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller {
  public function markAsRead(Request $request) {
    $notification = Notification::find($request->notification_id);
    if ($notification && !$notification->is_read) {
      $notification->is_read = true;
      $notification->save();
    }
    return redirect($notification->route);
  }
}
