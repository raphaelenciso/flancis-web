<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppointmentTable extends Component {
  public $appointments;

  public function __construct($appointments) {
    $this->appointments = $appointments;
  }

  public function render() {
    return view('components.appointment-table');
  }
}
