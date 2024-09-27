<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\ActivitiesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Customer\CustomerHomeController;
use App\Http\Controllers\Customer\BookAppointmentController;
use App\Http\Controllers\Customer\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Customer\ServicesController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\SettingsController;

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
// Route::get('/users/{id}', [UserController::class, 'view']);
Route::put('/profile', [UserController::class, 'update']);

Route::get('/schedule/appointments', [ScheduleController::class, 'index']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPasswordForm']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);

Route::prefix('/customer')->group(function () {
  Route::get('/home', [CustomerHomeController::class, 'index']);

  Route::get('/book-appointment', [BookAppointmentController::class, 'index'])->name('book-appointment.index');
  Route::post('/book-appointment', [BookAppointmentController::class, 'store'])->name('book-appointment.store');


  Route::get('/activities', [ActivitiesController::class, 'index']);
  Route::post('/submit-rating', [ActivitiesController::class, 'submitRating']);

  Route::get('/profile', [ProfileController::class, 'show']);

  Route::get('/services', [ServicesController::class, 'index']);
});

Route::redirect('/customer', '/customer/home');


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
  Route::get('/customers/{id}', [CustomerController::class, 'show']);
  Route::put('/customers/{id}', [CustomerController::class, 'update']);

  Route::get('/employees', [EmployeeController::class, 'index']); // display
  Route::get('/employees/add', [EmployeeController::class, 'create']); // display
  Route::post('/employees', [EmployeeController::class, 'store']);
  Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit']); //display
  Route::put('/employees/{id}', [EmployeeController::class, 'update']);

  Route::get('/ratings', [RatingController::class, 'index']);
  Route::get('/ratings/{id}', [RatingController::class, 'show']);

  Route::get('/resources', [ResourceController::class, 'index']); //display
  Route::post('/resources', [ResourceController::class, 'store']);
  Route::put('/resources/{id}', [ResourceController::class, 'update']);
  Route::delete('/resources/{id}', [ResourceController::class, 'destroy']);

  Route::get('/promos', [PromoController::class, 'index']);
  Route::post('/promos', [PromoController::class, 'store']);
  Route::put('/promos/{id}', [PromoController::class, 'update']);
  Route::delete('/promos/{id}', [PromoController::class, 'destroy']);

  Route::get('/calendar', [CalendarController::class, 'index']);
  Route::get('/appointments/date/{date}', [CalendarController::class, 'getAppointmentsByDate']);

  Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);

  Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports.index');
  Route::get('/reports/export/{period}', [ReportsController::class, 'export'])->name('admin.reports.export');
  Route::get('/reports/data/{period?}', [ReportsController::class, 'fetchReportData'])->name('admin.reports.data');

  Route::get('/employees/list', [AppointmentController::class, 'getEmployees']);

  Route::get('/settings', [SettingsController::class, 'index']);
  Route::post('/settings/upload-qr', [SettingsController::class, 'uploadQR']);
  Route::delete('/settings/remove-qr', [SettingsController::class, 'removeQR']);
});

Route::redirect('/admin', '/admin/dashboard');
