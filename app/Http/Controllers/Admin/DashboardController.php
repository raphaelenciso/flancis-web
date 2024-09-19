<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
  public function index() {
    $totalCustomers = User::where('role', 'customer')->count();

    $totalSales = Appointment::where('appointments_tbl.status', 'completed')
      ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
      ->sum('services_tbl.price');

    $totalEmployees = Employee::count();

    $totalAppointments = Appointment::count();

    $topServices = Service::select('services_tbl.service_id', 'services_tbl.service_name as name')
      ->leftJoin('service_ratings_tbl', 'services_tbl.service_id', '=', 'service_ratings_tbl.service_id')
      ->groupBy('services_tbl.service_id', 'services_tbl.service_name')
      ->selectRaw('AVG(service_ratings_tbl.rating) as avg_rating, COUNT(service_ratings_tbl.rating_id) as rating_count')
      ->orderByDesc('avg_rating')
      ->orderByDesc('rating_count')
      ->limit(5)
      ->get();

    $todayAppointments = Appointment::with(['user', 'service'])
      ->whereDate('appointment_date', now()->toDateString())
      ->orderBy('appointment_time')
      ->get();

    return view('admin.dashboard', compact(
      'totalCustomers',
      'totalSales',
      'totalEmployees',
      'totalAppointments',
      'topServices',
      'todayAppointments'
    ));
  }
}
