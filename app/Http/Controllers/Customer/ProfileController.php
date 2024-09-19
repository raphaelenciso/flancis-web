<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller {

  public function show() {
    $user = User::findOrFail(auth()->id());
    return view('customer.profile', compact('user'));
  }
}
