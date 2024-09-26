<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller {
  public function showForgotPasswordForm() {
    return view('forgot-password');
  }

  public function submitForgotPasswordForm(Request $request) {
    $request->validate([
      'email' => 'required|email|exists:users_tbl',
    ], [
      'email.exists' => 'No account found with this email address.',
    ]);

    $token = Str::random(64);

    try {
      DB::table('password_reset_tokens')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => now()
      ]);

      Mail::to($request->email)->send(new ForgotPasswordMail($token));

      return back()->with('status', 'We have e-mailed your password reset link!');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'An error occurred. Please try again later.');
    }
  }

  public function showResetPasswordForm($token) {
    $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();

    if (!$passwordReset) {
      return redirect('/forgot-password')->with('error', 'Invalid token!');
    }

    return view('reset-password', ['token' => $token]);
  }

  public function submitResetPasswordForm(Request $request) {
    $request->validate([
      'token' => 'required',
      'password' => 'required|string|min:6|confirmed',
      'password_confirmation' => 'required'
    ]);

    $passwordReset = DB::table('password_reset_tokens')
      ->where('token', $request->token)
      ->first();

    if (!$passwordReset) {
      return back()->withInput()->with('error', 'Invalid token!');
    }

    $user = User::where('email', $passwordReset->email)->first();

    if (!$user) {
      return back()->withInput()->with('error', 'User not found!');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    DB::table('password_reset_tokens')->where('email', $passwordReset->email)->delete();

    return redirect('/signin')->with('status', 'Your password has been changed!');
  }
}
