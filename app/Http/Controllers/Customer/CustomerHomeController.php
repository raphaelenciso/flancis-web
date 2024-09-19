<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Appointment;
use App\Models\ServiceType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerHomeController extends Controller {
  public function index() {
    $promos = Promo::with('services')
      ->where('end_date', '>=', now())
      ->orderBy('start_date', 'desc')
      ->get()
      ->map(function ($promo) {
        $promo->percent_discount = (int)$promo->percent_discount;
        return $promo;
      });

    $recentAppointments = Appointment::with('service')
      ->where('user_id', Auth::id())
      ->orderBy('appointment_date', 'desc')
      ->take(3)
      ->get();

    $serviceTypes = ServiceType::with('services')->where('status', 'active')->get();

    $topServices = Service::select('services_tbl.service_id', 'services_tbl.service_name as name')
      ->leftJoin('service_ratings_tbl', 'services_tbl.service_id', '=', 'service_ratings_tbl.service_id')
      ->groupBy('services_tbl.service_id', 'services_tbl.service_name')
      ->selectRaw('AVG(service_ratings_tbl.rating) as avg_rating, COUNT(service_ratings_tbl.rating_id) as rating_count')
      ->orderByDesc('avg_rating')
      ->orderByDesc('rating_count')
      ->limit(5)
      ->get();

    return view('customer.home', compact('promos', 'recentAppointments', 'serviceTypes', 'topServices'));
  }

  // ... other methods ...
}
