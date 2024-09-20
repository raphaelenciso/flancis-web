<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller {
  public function index() {
    $appointments = Appointment::with(['user', 'service', 'promo'])
      ->orderBy('appointment_date', 'desc')
      ->orderBy('appointment_time', 'desc')
      ->get();
    return view('admin.appointments', compact('appointments'));
  }

  public function show($id) {
    $appointment = Appointment::with(['user', 'service', 'promo'])->findOrFail($id);
    return response()->json($appointment);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'status' => 'required|in:pending,confirmed,completed,rejected',
      'admin_note' => 'nullable|string',
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->update($request->only(['status', 'admin_note']));

    return response()->json([
      'success' => true,
      'message' => 'Appointment updated successfully.',
      'appointment' => $appointment
    ]);
  }

  public function create() {
    $services = Service::where('status', 'active')->get();
    return view('customer.book-appointment', compact('services'));
  }
}
