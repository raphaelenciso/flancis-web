<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\ServiceType;

class HomeController extends Controller {
  public function index() {
    $serviceTypes = ServiceType::with('services')->where('status', 'active')->get();
    return view('home', compact('serviceTypes'));
  }

  public function submitForm(Request $request) {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'message' => 'required',
    ]);

    // Send email
    Mail::to('flancisg28@gmail.com')->send(new ContactFormMail($validated));

    return response()->json(['message' => 'Thank you for your message. We will get back to you shortly.']);
  }
}
