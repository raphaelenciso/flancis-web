<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmployeeForm extends Component {
  public $employee;

  public function __construct($employee = null) {
    $this->employee = $employee;
  }

  public function render() {
    return view('components.employee-form');
  }
}
