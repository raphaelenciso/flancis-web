<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable {
  use Queueable, SerializesModels;

  public $token;

  public function __construct($token) {
    $this->token = $token;
  }

  public function build() {
    return $this->view('emails.forgot-password')
      ->subject('Reset Your Password');
  }
}