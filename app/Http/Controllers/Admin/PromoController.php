<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PromoController extends Controller {
  public function index() {
    $promos = Promo::with('services')->orderBy('created_at', 'DESC')->get();
    $services = Service::all();
    return view('admin.promos', compact('promos', 'services'));
  }

  public function store(Request $request) {
    $request->validate([
      'promo_name' => 'required|string|max:100',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'percent_discount' => 'required|numeric',
      'service_id' => 'required|array',
      'service_id.*' => 'exists:services_tbl,service_id',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $promoId = Str::random(16);

    $promoData = [
      'promo_id' => $promoId,
      'promo_name' => $request->promo_name,
      'percent_discount' => $request->percent_discount,
      'start_date' => $request->start_date,
      'end_date' => $request->end_date,
    ];

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/promos'), $imageName);
      $promoData['image'] = 'images/promos/' . $imageName;
    }

    $promo = Promo::create($promoData);

    if ($promo->promo_id) {
      $promo->services()->attach($request->service_id);
    } else {
      return response()->json(['error' => 'Failed to create promo'], 500);
    }

    return response()->json([
      'success' => true,
      'message' => 'Promo added successfully.',
      'promo' => $promo->load('services')
    ]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'promo_name' => 'required|string|max:100',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'percent_discount' => 'required|numeric|min:0|max:100',
      'service_id' => 'required|array',
      'service_id.*' => 'exists:services_tbl,service_id',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $promo = Promo::findOrFail($id);
    $promo->promo_name = $request->promo_name;
    $promo->percent_discount = $request->percent_discount;
    $promo->start_date = $request->start_date;
    $promo->end_date = $request->end_date;

    if ($request->hasFile('image')) {
      if ($promo->image) {
        File::delete(public_path($promo->image));
      }

      $image = $request->file('image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/promos'), $imageName);
      $promo->image = 'images/promos/' . $imageName;
    }

    $promo->save();

    $promo->services()->sync($request->service_id);

    return response()->json([
      'success' => true,
      'message' => 'Promo updated successfully.',
      'promo' => $promo->load('services')
    ]);
  }

  public function destroy($id) {
    $promo = Promo::findOrFail($id);

    if ($promo->image) {
      File::delete(public_path($promo->image));
    }

    $promo->delete();

    return response()->json([
      'success' => true,
      'message' => 'Promo deleted successfully.'
    ]);
  }
}
