<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller {
  public function index() {
    $events = Appointment
      ::where('status', 'confirmed')
      ->with(['service'])
      // ::with(['service'])
      ->get()
      ->map(function ($appointment) {
        try {
          $date = Carbon::parse($appointment->appointment_date)->format('Y-m-d');
          $time = Carbon::parse($appointment->appointment_time)->format('H:i:s');
          $start = $date . 'T' . $time;

          return [
            'title' => $appointment->service->service_name,
            'start' => $start,
          ];
        } catch (\Exception $e) {
          Log::error('Error parsing appointment date/time', [
            'appointment_id' => $appointment->id,
            'date' => $appointment->appointment_date,
            'time' => $appointment->appointment_time,
            'error' => $e->getMessage()
          ]);
          return null;
        }
      })
      ->filter(); // Remove any null values

    return view('admin.calendar', compact('events'));
  }

  public function getAppointmentsByDate($date) {
    $appointments = Appointment::where('status', 'confirmed')
      ->whereDate('appointment_date', $date)
      ->with(['user', 'service'])
      ->orderBy('appointment_time')
      ->get();

    return response()->json($appointments);
  }
}
