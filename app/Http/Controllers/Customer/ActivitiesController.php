<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\ServiceRating;
use Carbon\Carbon;

class ActivitiesController extends Controller {
  public function index(Request $request) {
    $user_id = Auth::id();
    $search = $request->input('search');

    $appointments = Appointment::with(['service.serviceType', 'promo'])
      ->where('user_id', $user_id)
      ->when($search, function ($query) use ($search) {
        return $query->whereHas('service', function ($q) use ($search) {
          $q->where('service_name', 'like', "%{$search}%")
            ->orWhereHas('serviceType', function ($q) use ($search) {
              $q->where('service_type', 'like', "%{$search}%");
            });
        });
      })
      ->orderByDesc('appointment_date')
      ->orderByDesc('appointment_time')
      ->get();

    $currentMonth = Carbon::now()->format('Y-m');

    $appointmentsByCategory = [
      'upcoming' => $appointments->filter(function ($appointment) {
        return $appointment->appointment_date >= Carbon::today() && !in_array($appointment->status, ['cancelled', 'rejected']);
      }),
      'recent' => $appointments->filter(function ($appointment) use ($currentMonth) {
        return $appointment->appointment_date->format('Y-m') === $currentMonth;
      }),
      'cancelled' => $appointments->where('status', 'cancelled'),
      'rejected' => $appointments->where('status', 'rejected'),
      'completed' => $appointments->where('status', 'completed'),
      'all' => $appointments,
    ];

    return view('customer.activities', compact('appointmentsByCategory', 'search'));
  }

  public function submitRating(Request $request) {
    $request->validate([
      'appointmentId' => 'required|exists:appointments_tbl,appointment_id',
      'rating' => 'required|integer|min:1|max:5',
      'description' => 'nullable|string|max:255',
    ]);

    $appointmentId = $request->input('appointmentId');
    $rating = $request->input('rating');
    $description = $request->input('description');

    $appointment = Appointment::findOrFail($appointmentId);

    // Check if the appointment belongs to the authenticated user
    if ($appointment->user_id !== Auth::id()) {
      return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Check if the appointment has already been rated
    if ($appointment->is_rated) {
      return response()->json(['error' => 'Appointment has already been rated'], 400);
    }

    ServiceRating::create([
      'appointment_id' => $appointmentId,
      'user_id' => $appointment->user_id,
      'service_id' => $appointment->service_id,
      'rating' => $rating,
      'description' => $description,
    ]);

    $appointment->update(['is_rated' => true]);

    return response()->json(['message' => 'Rating submitted successfully']);
  }
}
