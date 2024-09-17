<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class HomeController extends Controller {
  public function index() {
    return view('home');
  }

  public function submitForm(Request $request) {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'message' => 'required',
    ]);

    // Send email
    Mail::to('psyruz18@gmail.com')->send(new ContactFormMail($validated));

    return response()->json(['message' => 'Thank you for your message. We will get back to you shortly.']);
  }
}
