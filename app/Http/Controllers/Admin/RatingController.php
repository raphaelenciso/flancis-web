<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRating;
use Illuminate\Http\Request;

class RatingController extends Controller {
  public function index() {
    $ratings = ServiceRating::with(['user', 'service'])->orderBy('created_at', 'desc')->get();
    return view('admin.ratings', compact('ratings'));
  }

  public function show($id) {
    $rating = ServiceRating::with(['user', 'service'])->findOrFail($id);
    return response()->json($rating);
  }
}
