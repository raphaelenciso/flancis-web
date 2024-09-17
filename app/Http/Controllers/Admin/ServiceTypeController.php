<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ServiceTypeController extends Controller {
  public function index() {
    $serviceTypes = ServiceType::orderBy('created_at', 'DESC')->get();
    return view('admin.service-types', compact('serviceTypes'));
  }

  public function store(Request $request) {
    $request->validate([
      'service_type' => 'required|string|max:255|unique:service_types_tbl,service_type',
      'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status' => 'required|in:active,inactive',
    ]);

    $serviceType = new ServiceType();
    $serviceType->service_type = $request->service_type;
    $serviceType->status = $request->status;

    if ($request->hasFile('service_image')) {
      $image = $request->file('service_image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/service-types'), $imageName);
      $serviceType->service_image = 'images/service-types/' . $imageName;
    }

    $serviceType->save();

    return response()->json([
      'success' => true,
      'message' => 'Service type added successfully.',
      'serviceType' => $serviceType
    ]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'service_type' => 'required|string|max:255|unique:service_types_tbl,service_type,' . $id . ',service_type_id',
      'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status' => 'required|in:active,inactive',
    ]);

    $serviceType = ServiceType::findOrFail($id);
    $serviceType->service_type = $request->service_type;
    $serviceType->status = $request->status;

    if ($request->hasFile('service_image')) {
      // Delete old image
      if ($serviceType->service_image) {
        File::delete(public_path($serviceType->service_image));
      }

      $image = $request->file('service_image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/service-types'), $imageName);
      $serviceType->service_image = 'images/service-types/' . $imageName;
    }

    $serviceType->save();

    return response()->json([
      'success' => true,
      'message' => 'Service type updated successfully.',
      'serviceType' => $serviceType
    ]);
  }

  public function destroy($id) {
    $serviceType = ServiceType::findOrFail($id);

    if ($serviceType->service_image) {
      File::delete(public_path($serviceType->service_image));
    }

    $serviceType->delete();

    return response()->json([
      'success' => true,
      'message' => 'Service type deleted successfully.'
    ]);
  }
}
