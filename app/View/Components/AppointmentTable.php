<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppointmentTable extends Component {
  public $appointments;
  public $id;

  public function __construct($appointments, $id) {
    $this->appointments = $appointments;
    $this->id = $id;
  }

  public function render() {
    return view('components.appointment-table');
  }
}
