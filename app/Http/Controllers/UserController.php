<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
  // public function view($id) {
  //   $user = User::findOrFail($id);
  //   return response()->json($user);
  // }

  public function update(Request $request) {
    $userId = $request->input('user_id');
    $user = User::findOrFail($userId);

    try {
      $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female,other',
        'phone' => 'required|string|max:20',
        'birthday' => 'required|date',
        'address' => 'required|string|max:500',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'current_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|required_with:current_password|confirmed',
      ]);

      if ($request->filled('current_password')) {
        if (!Hash::check($request->current_password, $user->password)) {
          throw ValidationException::withMessages([
            'current_password' => ['The provided password does not match your current password.'],
          ]);
        }

        $user->password = Hash::make($request->new_password);
      }

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
    } catch (ValidationException $e) {
      return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
      return back()->with('error', 'An error occurred while updating your profile. Please try again.')->withInput();
    }
  }
}
