<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller {
  public function index() {
    $paymentOptions = [
      'gcash' => $this->getQRCode('gcash'),
      'landbank' => $this->getQRCode('landbank'),
      'bdo' => $this->getQRCode('bdo'),
    ];

    return view('admin.settings', compact('paymentOptions'));
  }

  public function uploadQR(Request $request) {
    $request->validate([
      'type' => 'required|in:gcash,landbank,bdo',
      'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $type = $request->input('type');
    $image = $request->file('qr_image');
    $imageName = $type . '.' . $image->getClientOriginalExtension();

    $image->move(public_path('images/payment-options'), $imageName);

    return redirect()->back()->with('success', ucfirst($type) . ' QR code uploaded successfully.');
  }

  public function removeQR(Request $request) {
    $request->validate([
      'type' => 'required|in:gcash,landbank,bdo',
    ]);

    $type = $request->input('type');
    $imagePath = public_path('images/payment-options/' . $type . '.*');
    $files = glob($imagePath);

    if (!empty($files)) {
      foreach ($files as $file) {
        unlink($file);
      }
    }

    return redirect()->back()->with('success', ucfirst($type) . ' QR code removed successfully.');
  }

  private function getQRCode($type) {
    $imagePath = public_path('images/payment-options/' . $type . '.*');
    $files = glob($imagePath);

    return !empty($files) ? basename($files[0]) : null;
  }
}
