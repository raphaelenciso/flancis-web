<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\ServiceRating;

class ActivitiesController extends Controller {
  public function index() {
    $user_id = Auth::id();
    $appointments = Appointment::with(['service.serviceType', 'promo'])
      ->where('user_id', $user_id)
      ->orderByDesc('appointment_date')
      ->orderByDesc('appointment_time')
      ->get();

    return view('customer.activities', compact('appointments'));
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
