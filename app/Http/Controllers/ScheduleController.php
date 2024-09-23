<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller {
  //
  public function index() {
    $now = Carbon::now('Asia/Manila');
    $next24Hours = $now->copy()->addDay();

    $appointmentsWithin1h = Appointment::where('status', 'confirmed')
      ->where('notified1h', false)
      ->where('appointment_date', '=', $now->toDateString())
      ->where('appointment_time', '>=', $now->toTimeString())
      ->where('appointment_time', '<=', $now->copy()->addHour()->addMinutes(10)->toTimeString())
      ->orderBy('appointment_time')
      ->get();

    $appointmentsWithin24h = Appointment::where('status', 'confirmed')
      ->where('notified1d', false)
      ->where(function ($query) use ($now, $next24Hours) {
        $query->where(function ($query) use ($now) {
          $query->where('appointment_date', '=', $now->toDateString())
            ->where('appointment_time', '>=', $now->toTimeString());
        })->orWhere(function ($query) use ($next24Hours) {
          $query->where('appointment_date', '=', $next24Hours->toDateString())
            ->where('appointment_time', '<=', $next24Hours->toTimeString());
        });
      })
      ->orderBy('appointment_time')
      ->get();

    return response()->json([
      'appointmentsWithin1h' => $appointmentsWithin1h,
      'appointmentsWithin24h' => $appointmentsWithin24h
    ]);
  }
}
