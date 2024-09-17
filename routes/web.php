<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\ActivitiesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Customer\BookAppointmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// LANDING PAGE
Route::get('/', [HomeController::class, 'index']);
Route::post('/contact', [HomeController::class, 'submitForm']);


// AUTH
Route::get('/signin', [AuthController::class, 'showSignin']);
Route::post('/signin', [AuthController::class, 'signin']);

Route::get('/signup', [AuthController::class, 'showSignup']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/profile', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'view']);

Route::prefix('/customer')->group(function () {
  Route::get('/home', function () {
    return view('customer.home');
  });

  Route::get('/book-appointment', [BookAppointmentController::class, 'index']);
  Route::post('/book-appointment', [BookAppointmentController::class, 'store']);


  Route::get('/activities', [ActivitiesController::class, 'index']);
  Route::post('/submit-rating', [ActivitiesController::class, 'submitRating']);

  Route::get('/profile', [UserController::class, 'show']);
  Route::put('/profile', [UserController::class, 'update']);
});

Route::prefix('/admin')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index']);
  Route::get('/service-types', [ServiceTypeController::class, 'index']);
  Route::post('/service-types', [ServiceTypeController::class, 'store']);
  Route::put('/service-types/{id}', [ServiceTypeController::class, 'update']);
  Route::delete('/service-types/{id}', [ServiceTypeController::class, 'destroy']);

  Route::get('/services', [ServiceController::class, 'index']);
  Route::post('/services', [ServiceController::class, 'store']);
  Route::put('/services/{id}', [ServiceController::class, 'update']);
  Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

  Route::get('/appointments', [AppointmentController::class, 'index']);
  Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
  Route::put('/appointments/{id}', [AppointmentController::class, 'update']);

  Route::get('/customers', [CustomerController::class, 'index']);
  Route::put('/customers/{id}', [CustomerController::class, 'update']);
});
