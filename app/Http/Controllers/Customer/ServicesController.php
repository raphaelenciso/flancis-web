<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServicesController extends Controller {
  public function index() {
    $serviceTypes = ServiceType::with(['services' => function ($query) {
      $query->withAvg('serviceRatings', 'rating')
        ->withCount('serviceRatings');
    }])->where('status', 'active')->get();
    return view('customer.services', compact('serviceTypes'));
  }
}
