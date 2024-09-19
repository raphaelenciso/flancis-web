<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

  public function showSignup() {
    return view('signup');
  }

  public function showSignin() {
    return view('signin');
  }

  public function signup(Request $request) {
    $request->validate([
      'username' => 'required|unique:users_tbl',
      'first_name' => 'required',
      'last_name' => 'required',
      'gender' => 'required',
      'email' => 'required|email|unique:users_tbl',
      'phone' => 'required',
      'birthday' => 'required|date',
      'address' => 'required',
      'password' => 'required|confirmed',
    ]);

    $otp = rand(100000, 999999);
    $userData = $request->all();
    $userData['password'] = Hash::make($request->password);
    $userData['otp'] = $otp;

    session(['user_data' => $userData]);

    // Send OTP to user's email
    Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
      $message->to($request->email)->subject('OTP for Sign Up');
    });

    return redirect('/signup')->with('show_otp_form', true)->with('message', 'OTP sent to your email. Please verify.');
  }

  public function verifyOtp(Request $request) {
    $request->validate([
      'otp' => 'required|numeric',
    ]);

    $userData = session('user_data');

    if ($request->otp == $userData['otp']) {
      $user = User::create([
        'username' => $userData['username'],
        'first_name' => $userData['first_name'],
        'last_name' => $userData['last_name'],
        'middle_name' => $userData['middle_name'] ?? null,
        'gender' => $userData['gender'],
        'email' => $userData['email'],
        'phone' => $userData['phone'],
        'birthday' => $userData['birthday'],
        'address' => $userData['address'],
        'password' => $userData['password'],
        'role' => 'customer',
      ]);

      session()->forget('user_data');
      return redirect('/signin')->with('message', 'Registration successful. You can now Sign In.');
    }

    return redirect('/signup')->with('show_otp_form', true)->with('message', 'Invalid OTP. Please try again.');
  }

  public function signin(Request $request) {
    $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);

    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
      auth()->login($user);
      if ($user->role === 'customer') {
        return redirect('/customer/home');
      } else {
        return redirect('/admin/dashboard');
      }
    }

    return back()->withInput($request->only('username'))->with('error', 'Invalid username or password.');
  }

  // Add this method to handle logout
  public function logout(Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/signin');
  }
}
