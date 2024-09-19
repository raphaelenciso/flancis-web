<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification; // Add this line
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendAppointmentReminder;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Added for fetching admin users

class BookAppointmentController extends Controller {
  public function index() {
    $serviceTypes = ServiceType::where('status', 'active')->get();
    $services = Service::with('serviceType')
      ->where('status', 'active')
      ->whereHas('serviceType', function ($query) {
        $query->where('status', 'active');
      })
      ->get();

    return view('customer.book-appointment', compact('serviceTypes', 'services'));
  }

  public function store(Request $request) {
    $request->validate([
      'appointment_date' => 'required|date',
      'appointment_time' => 'required',
      'service_id' => 'required|exists:services_tbl,service_id',
      'payment_type' => 'required|in:cash,gcash,bank_transfer',
      'remarks' => 'nullable|string',
      'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);


    $userId = Auth::id();

    if ($request->hasFile('proof')) {
      $proofImage = $request->file('proof');
      $proofImageName = time() . '_' . $proofImage->getClientOriginalName();
      $proofImage->move(public_path('images/appointment-proofs'), $proofImageName);
      $proofPath = 'images/appointment-proofs/' . $proofImageName;
    } else {
      return redirect()->back()->with('error', 'Proof of payment is required.');
    }

    $appointment = new Appointment([
      'user_id' => $userId,
      'appointment_date' => $request->appointment_date,
      'appointment_time' => $request->appointment_time,
      'service_id' => $request->service_id,
      'payment_type' => $request->payment_type,
      'remarks' => $request->remarks,
      'status' => 'pending',
      'proof' => $proofPath,
    ]);

    $appointment->save();

    // Eager load related models
    $appointment->load('user', 'service');

    // Send confirmation email
    Mail::to(Auth::user()->email)->send(new AppointmentConfirmation($appointment));

    // Fetch all admin users
    $adminUsers = User::where('role', 'admin')->get();

    // Create notifications for all admin users
    foreach ($adminUsers as $admin) {
      Notification::create([
        'user_id' => $admin->user_id,
        'title' => 'New Appointment Booked',
        'message' => Auth::user()->username . ' booked an appointment.',
        'route' => '/admin/appointments',
      ]);
    }

    return redirect('/customer/book-appointment')
      ->with('success', 'Appointment booked successfully. A confirmation email has been sent, and a reminder email will be sent shortly.');
  }
}
