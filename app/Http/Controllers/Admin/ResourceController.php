<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller {
  public function index() {
    $resources = Resource::orderBy('created_at', 'DESC')->get();
    return view('admin.resources', compact('resources'));
  }

  public function store(Request $request) {
    $request->validate([
      'resource_name' => 'required|string|max:100',
      'quantity' => 'required|integer|min:0',
      'status' => 'required|in:available,unavailable',
    ]);

    $resource = new Resource();
    $resource->resource_name = $request->resource_name;
    $resource->quantity = $request->quantity;
    $resource->status = $request->status;
    $resource->save();

    return response()->json([
      'success' => true,
      'message' => 'Resource added successfully.',
      'resource' => $resource
    ]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'resource_name' => 'required|string|max:100',
      'quantity' => 'required|integer|min:0',
      'status' => 'required|in:available,unavailable',
    ]);

    $resource = Resource::findOrFail($id);
    $resource->resource_name = $request->resource_name;
    $resource->quantity = $request->quantity;
    $resource->status = $request->status;
    $resource->save();

    return response()->json([
      'success' => true,
      'message' => 'Resource updated successfully.',
      'resource' => $resource
    ]);
  }

  public function destroy($id) {
    $resource = Resource::findOrFail($id);
    $resource->delete();

    return response()->json([
      'success' => true,
      'message' => 'Resource deleted successfully.'
    ]);
  }
}
