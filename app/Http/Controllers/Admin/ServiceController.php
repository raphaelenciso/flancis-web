<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller {
  public function index() {
    $services = Service::with('serviceType')->orderBy('created_at', 'DESC')->get();
    $serviceTypes = ServiceType::all();
    return view('admin.services', compact('services', 'serviceTypes'));
  }

  public function store(Request $request) {
    $request->validate([
      'service_name' => 'required|string|max:100',
      'service_type_id' => 'required|exists:service_types_tbl,service_type_id',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status' => 'required|in:active,inactive',
    ]);

    $service = new Service();
    $service->service_name = $request->service_name;
    $service->service_type_id = $request->service_type_id;
    $service->price = $request->price;
    $service->description = $request->description;
    $service->status = $request->status;

    if ($request->hasFile('service_image')) {
      $image = $request->file('service_image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/services'), $imageName);
      $service->service_image = 'images/services/' . $imageName;
    }

    $service->save();

    return response()->json([
      'success' => true,
      'message' => 'Service added successfully.',
      'service' => $service
    ]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'service_name' => 'required|string|max:100',
      'service_type_id' => 'required|exists:service_types_tbl,service_type_id',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status' => 'required|in:active,inactive',
    ]);

    $service = Service::findOrFail($id);
    $service->service_name = $request->service_name;
    $service->service_type_id = $request->service_type_id;
    $service->price = $request->price;
    $service->description = $request->description;
    $service->status = $request->status;

    if ($request->hasFile('service_image')) {
      // Delete old image
      if ($service->service_image) {
        File::delete(public_path($service->service_image));
      }

      $image = $request->file('service_image');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images/services'), $imageName);
      $service->service_image = 'images/services/' . $imageName;
    }

    $service->save();

    return response()->json([
      'success' => true,
      'message' => 'Service updated successfully.',
      'service' => $service
    ]);
  }

  public function destroy($id) {
    $service = Service::findOrFail($id);

    if ($service->service_image) {
      File::delete(public_path($service->service_image));
    }

    $service->delete();

    return response()->json([
      'success' => true,
      'message' => 'Service deleted successfully.'
    ]);
  }
}
