<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class EmployeeAppointmentAssigned extends Mailable {
  use Queueable, SerializesModels;

  public $appointment;

  public function __construct(Appointment $appointment) {
    $this->appointment = $appointment;
  }

  public function envelope(): Envelope {
    return new Envelope(
      subject: 'New Appointment Assigned',
    );
  }

  public function content(): Content {
    return new Content(
      view: 'emails.employee-appointment-assigned',
    );
  }

  public function attachments(): array {
    return [];
  }
}
