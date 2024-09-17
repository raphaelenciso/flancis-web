<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;

class BookAppointmentController extends Controller {
  public function index() {
    $serviceTypes = ServiceType::all();
    $services = Service::with('serviceType')->get();

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

    return redirect('/customer/book-appointment')->with('success', 'Appointment booked successfully.');
  }
}
