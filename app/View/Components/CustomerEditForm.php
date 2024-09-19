<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomerEditForm extends Component {
  public $user;

  public function __construct($user) {
    $this->user = $user;
  }

  public function render() {
    return view('components.customer-edit-form');
  }
}
