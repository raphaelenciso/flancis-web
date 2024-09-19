<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller {
  public function index() {
    $customers = User::where('role', 'customer')->get();
    return view('admin.customers', compact('customers'));
  }

  public function show($id) {
    $user = User::findOrFail($id);
    return view('admin.customer-profile', compact('user'));
  }

  public function update(Request $request, $id) {
    $customer = User::findOrFail($id);

    $validatedData = $request->validate([
      'first_name' => 'required|string|max:100',
      'middle_name' => 'nullable|string|max:100',
      'last_name' => 'required|string|max:100',
      'gender' => 'required|in:male,female,other',
      'email' => 'required|email|max:36|unique:users_tbl,email,' . $id . ',user_id',
      'phone' => 'required|string|max:11',
      'birthday' => 'required|date',
      'address' => 'required|string|max:100',
    ]);

    $customer->update($validatedData);

    return response()->json([
      'success' => true,
      'message' => 'Customer updated successfully.',
      'customer' => $customer
    ]);
  }
}
