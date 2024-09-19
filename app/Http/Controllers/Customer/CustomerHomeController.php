<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Appointment;
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

    return view('customer.home', compact('promos', 'recentAppointments'));
  }

  // ... other methods ...
}
