<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
  // public function view($id) {
  //   $user = User::findOrFail($id);
  //   return response()->json($user);
  // }

  public function update(Request $request) {
    $userId = $request->input('user_id');
    $user = User::findOrFail($userId);

    $validatedData = $request->validate([
      'first_name' => 'required|string|max:255',
      'middle_name' => 'nullable|string|max:255',
      'last_name' => 'required|string|max:255',
      'gender' => 'required|in:male,female,other',
      'phone' => 'required|string|max:20',
      'birthday' => 'required|date',
      'address' => 'required|string|max:500',
      'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('picture')) {
      // Delete the old image if it exists
      if ($user->picture) {
        $oldImagePath = public_path('images/customer-pictures/' . $user->picture);
        if (file_exists($oldImagePath)) {
          unlink($oldImagePath);
        }
      }

      // Upload the new image
      $extension = $request->picture->extension();
      $imageName = $userId . '.' . $extension;
      $request->picture->move(public_path('images/customer-pictures'), $imageName);
      $validatedData['picture'] = $imageName;
    }

    $user->fill($validatedData);
    $user->save();

    return back()->with('success', 'Profile updated successfully!');
  }
}
