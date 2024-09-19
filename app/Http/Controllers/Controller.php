<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
  use AuthorizesRequests, ValidatesRequests;

  // convention names 

  // view 
  // index -> all
  // create -> indiv
  // edit -> for edit

  // resource / api call
  // store -> create 
  // show -> read indiv
  // update -> edit
  // destroy -> delete 
}
