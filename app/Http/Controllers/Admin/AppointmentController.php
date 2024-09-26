<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\AppointmentStatusUpdated;
use App\Mail\EmployeeAppointmentAssigned;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller {
  public function index() {
    $appointments = Appointment::with(['user', 'service', 'promo', 'employee'])
      ->orderBy('appointment_date', 'desc')
      ->orderBy('appointment_time', 'desc')
      ->get()
      ->map(function ($appointment) {
        $appointment->balance = $appointment->price / 2;
        return $appointment;
      });
    return view('admin.appointments', compact('appointments'));
  }

  public function show($id) {
    $appointment = Appointment::with(['user', 'service', 'promo', 'employee'])->findOrFail($id);
    $appointment->balance = $appointment->price / 2;
    $employees = Employee::select('employee_id', 'employee_first_name', 'employee_last_name')->get();
    return response()->json([
      'appointment' => $appointment,
      'employees' => $employees
    ]);
  }

  public function update(Request $request, $id) {
    $appointment = Appointment::findOrFail($id);

    $validatedData = $request->validate([
      'status' => 'required|in:pending,confirmed,rejected,cancelled,completed',
      'admin_note' => 'nullable|string',
      'employee_id' => 'nullable|exists:employees_tbl,employee_id',
      'balance' => 'nullable|numeric',
    ]);

    $oldStatus = $appointment->status;

    if ($oldStatus === 'pending' && $validatedData['status'] !== 'pending') {
      $validatedData['balance'] = $appointment->price / 2;
    }

    $appointment->update($validatedData);

    // Send email to customer
    Mail::to($appointment->user->email)->send(new AppointmentStatusUpdated($appointment));

    // If status is confirmed and an employee is assigned, send email to employee
    if ($validatedData['status'] === 'confirmed' && $appointment->employee) {
      Mail::to($appointment->employee->email)->send(new EmployeeAppointmentAssigned($appointment));
    }

    return response()->json(['success' => true, 'message' => 'Appointment updated successfully']);
  }

  public function create() {
    $services = Service::where('status', 'active')->get();
    return view('customer.book-appointment', compact('services'));
  }

  public function getEmployees() {
    $employees = Employee::select('employee_id', 'employee_first_name', 'employee_last_name')->get();
    return response()->json($employees);
  }
}
