<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller {
  public function index() {
    return view('admin.reports');
  }

  public function export($period = 'yearly') {
    $data = $this->fetchReportData($period)->getData(true);

    $csv = $this->generateCsv($data, $period);

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="report_' . $period . '_' . now()->format('Y-m-d') . '.csv"',
    ];

    return response($csv, 200, $headers);
  }

  private function generateCsv($data, $period) {
    $csv = fopen('php://temp', 'r+');

    // Earnings Overview
    fputcsv($csv, ['Earnings Overview - ' . ucfirst($period)]);
    fputcsv($csv, ['Period', 'Earnings']);
    foreach ($data['earningsData']['labels'] as $index => $label) {
      fputcsv($csv, [$label, $data['earningsData']['data'][$index]]);
    }
    fputcsv($csv, []); // Empty line for separation

    // Top Services
    fputcsv($csv, ['Top Services']);
    fputcsv($csv, ['Service Name', 'Average Rating', 'Rating Count']);
    foreach ($data['topServices'] as $service) {
      fputcsv($csv, [$service['name'], $service['avg_rating'], $service['rating_count']]);
    }
    fputcsv($csv, []);

    // Revenue Sources
    fputcsv($csv, ['Revenue Sources']);
    fputcsv($csv, ['Service Type', 'Appointment Count']);
    foreach ($data['serviceTypeRevenue'] as $revenueSource) {
      fputcsv($csv, [$revenueSource['service_type'], $revenueSource['appointment_count']]);
    }

    rewind($csv);
    $content = stream_get_contents($csv);
    fclose($csv);

    return $content;
  }

  public function fetchReportData($period = 'yearly') {
    $labels = [];
    $data = [];
    $startDate = now();
    $endDate = now();

    switch ($period) {
      case 'weekly':
        $labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $data = array_fill(0, 7, 0);
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $weeklySales = Appointment::where('appointments_tbl.status', 'completed')
          ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
          ->select(DB::raw('DAYOFWEEK(appointments_tbl.appointment_date) as day'), DB::raw('SUM(services_tbl.price) as total'))
          ->whereBetween('appointments_tbl.appointment_date', [$startDate, $endDate])
          ->groupBy('day')
          ->orderBy('day')
          ->pluck('total', 'day')
          ->toArray();

        foreach ($weeklySales as $day => $total) {
          $data[$day - 1] = $total;
        }
        break;

      case 'monthly':
        $labels = range(1, now()->daysInMonth);
        $data = array_fill(0, now()->daysInMonth, 0);
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $monthlySales = Appointment::where('appointments_tbl.status', 'completed')
          ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
          ->select(DB::raw('DAY(appointments_tbl.appointment_date) as day'), DB::raw('SUM(services_tbl.price) as total'))
          ->whereBetween('appointments_tbl.appointment_date', [$startDate, $endDate])
          ->groupBy('day')
          ->orderBy('day')
          ->pluck('total', 'day')
          ->toArray();

        foreach ($monthlySales as $day => $total) {
          $data[$day - 1] = $total;
        }
        break;

      case 'yearly':
      default:
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = array_fill(0, 12, 0);
        $startDate = now()->startOfYear();
        $endDate = now()->endOfYear();

        $yearlySales = Appointment::where('appointments_tbl.status', 'completed')
          ->join('services_tbl', 'appointments_tbl.service_id', '=', 'services_tbl.service_id')
          ->select(DB::raw('MONTH(appointments_tbl.appointment_date) as month'), DB::raw('SUM(services_tbl.price) as total'))
          ->whereBetween('appointments_tbl.appointment_date', [$startDate, $endDate])
          ->groupBy('month')
          ->orderBy('month')
          ->pluck('total', 'month')
          ->toArray();

        foreach ($yearlySales as $month => $total) {
          $data[$month - 1] = $total;
        }
        break;
    }

    $topServices = Service::select('services_tbl.service_id', 'services_tbl.service_name as name')
      ->leftJoin('service_ratings_tbl', 'services_tbl.service_id', '=', 'service_ratings_tbl.service_id')
      ->join('appointments_tbl', 'services_tbl.service_id', '=', 'appointments_tbl.service_id')
      ->where('appointments_tbl.status', 'completed')
      ->whereBetween('appointments_tbl.appointment_date', [$startDate, $endDate])
      ->groupBy('services_tbl.service_id', 'services_tbl.service_name')
      ->selectRaw('AVG(service_ratings_tbl.rating) as avg_rating, COUNT(service_ratings_tbl.rating_id) as rating_count')
      ->orderByDesc('avg_rating')
      ->orderByDesc('rating_count')
      ->limit(5)
      ->get();

    $serviceTypeRevenue = ServiceType::select('service_types_tbl.service_type_id', 'service_types_tbl.service_type')
      ->join('services_tbl', 'service_types_tbl.service_type_id', '=', 'services_tbl.service_type_id')
      ->join('appointments_tbl', 'services_tbl.service_id', '=', 'appointments_tbl.service_id')
      ->where('appointments_tbl.status', 'completed')
      ->whereBetween('appointments_tbl.appointment_date', [$startDate, $endDate])
      ->groupBy('service_types_tbl.service_type_id', 'service_types_tbl.service_type')
      ->selectRaw('COUNT(appointments_tbl.appointment_id) as appointment_count')
      ->orderByDesc('appointment_count')
      ->get();

    return response()->json([
      'period' => $period,
      'earningsData' => [
        'labels' => $labels,
        'data' => $data,
      ],
      'topServices' => $topServices,
      'serviceTypeRevenue' => $serviceTypeRevenue,
    ]);
  }
}
