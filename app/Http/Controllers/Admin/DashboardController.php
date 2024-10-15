<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceType;
use Carbon\Carbon;

class DashboardController extends Controller {
  public function index() {
    $now = Carbon::now();
    $twentyFourHoursAgo = $now->copy()->subHours(24);

    // start main cards (24-hour data)
    $totalCustomers = User::where('role', 'customer')
      ->whereBetween('created_at', [$twentyFourHoursAgo, $now])
      ->count();
    $totalSales = Appointment::where('appointments_tbl.status', 'completed')
      ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
      ->whereBetween('appointments_tbl.appointment_date', [$twentyFourHoursAgo, $now])
      ->sum('services_tbl.price');
    $totalEmployees = Employee::count();
    $totalAppointments = Appointment::whereBetween('created_at', [$twentyFourHoursAgo, $now])
      ->count();
    // end main cards

    // Monthly data for earnings overview
    $monthlySales = Appointment::where('appointments_tbl.status', 'completed')
      ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
      ->select(DB::raw('MONTH(appointments_tbl.appointment_date) as month'), DB::raw('SUM(services_tbl.price) as total'))
      ->whereYear('appointments_tbl.appointment_date', date('Y'))
      ->groupBy('month')
      ->orderBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $monthlyData = array_replace(array_fill(1, 12, 0), $monthlySales);

    // Top services (all-time data)
    $topServices = Service::select('services_tbl.service_id', 'services_tbl.service_name as name')
      ->leftJoin('service_ratings_tbl', 'services_tbl.service_id', '=', 'service_ratings_tbl.service_id')
      ->groupBy('services_tbl.service_id', 'services_tbl.service_name')
      ->selectRaw('AVG(service_ratings_tbl.rating) as avg_rating, COUNT(service_ratings_tbl.rating_id) as rating_count')
      ->orderByDesc('avg_rating')
      ->orderByDesc('rating_count')
      ->limit(5)
      ->get();

    // Revenue sources (all-time data)
    $serviceTypeRevenue = ServiceType::select('service_types_tbl.service_type_id', 'service_types_tbl.service_type')
      ->join('services_tbl', 'service_types_tbl.service_type_id', '=', 'services_tbl.service_type_id')
      ->join('appointments_tbl', 'services_tbl.service_id', '=', 'appointments_tbl.service_id')
      ->where('appointments_tbl.status', 'completed')
      ->groupBy('service_types_tbl.service_type_id', 'service_types_tbl.service_type')
      ->selectRaw('COUNT(appointments_tbl.appointment_id) as appointment_count')
      ->orderByDesc('appointment_count')
      ->get();

    $todayAppointments = Appointment::with(['user', 'service'])
      ->whereDate('appointment_date', $now->toDateString())
      ->orderBy('appointment_time')
      ->get();

    return view('admin.dashboard', compact(
      'totalCustomers',
      'totalSales',
      'totalEmployees',
      'totalAppointments',
      'monthlyData',
      'topServices',
      'serviceTypeRevenue',
      'todayAppointments',
    ));
  }
}
