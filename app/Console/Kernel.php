<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel {
  /**
   * Define the application's command schedule.
   */
  protected function schedule(Schedule $schedule): void {
    $schedule->call(function () {
      $now = Carbon::now('Asia/Manila');
      $next24Hours = $now->copy()->addDay();

      Log::info('Scheduler running at: ' . $now->toDateTimeString());

      // Check for appointments within 1 hour
      $appointmentsWithin1Hour = Appointment::where('status', 'confirmed')
        ->where('notified1h', false)
        ->where('appointment_date', '=', $now->toDateString())
        ->where('appointment_time', '>=', $now->toTimeString())
        ->where('appointment_time', '<=', $now->copy()->addHour()->addMinutes(10)->toTimeString())
        ->orderBy('appointment_time')
        ->get();

      foreach ($appointmentsWithin1Hour as $appointment) {
        Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment, '1 hour'));
        $appointment->notified1h = true;
        $appointment->save();
        Log::info('Sent 1-hour reminder to: ' . $appointment->user->email);
      }

      // Check for appointments within 24 hours
      $appointmentsWithin24Hours = Appointment::where('status', 'confirmed')
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

      foreach ($appointmentsWithin24Hours as $appointment) {
        Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment, '24 hours'));
        $appointment->notified1d = true;
        $appointment->save();
        Log::info('Sent 24-hour reminder to: ' . $appointment->user->email);
      }
    })->everyMinute(); // Change to every minute
  }

  /**
   * Register the commands for the application.
   */
  protected function commands(): void {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
