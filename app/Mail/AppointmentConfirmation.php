<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable {
  use Queueable, SerializesModels;

  public $appointment;

  public function __construct(Appointment $appointment) {
    $this->appointment = $appointment;
  }

  public function build() {
    return $this->view('emails.appointment-confirmation')
      ->subject('Appointment Confirmation');
  }
}
