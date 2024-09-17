<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {

  public function show() {
    $user = User::findOrFail(auth()->id());
    return view('customer.profile', compact('user'));
  }

  public function view($id) {
    $user = User::findOrFail($id);
    return response()->json($user);
  }


  public function update(Request $request) {
    $user = User::findOrFail(auth()->id());

    $validatedData = $request->validate([
      'first_name' => 'required|string|max:255',
      'middle_name' => 'nullable|string|max:255',
      'last_name' => 'required|string|max:255',
      'gender' => 'required|in:male,female,other',
      'phone' => 'required|string|max:20',
      'birthday' => 'required|date',
      'address' => 'required|string|max:500',
    ]);

    $user->fill($validatedData);
    $user->save();

    if ($user->role === 'customer') {
      return redirect('/customer/profile')->with('success', 'Profile updated successfully!');
    } elseif ($user->role === 'admin') {
      return redirect('/admin/customers')->with('success', 'Profile updated successfully!');
    }
  }
}
