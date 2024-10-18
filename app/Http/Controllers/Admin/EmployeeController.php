<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
  public function index() {
    $employees = Employee::get();
    return view('admin.employees', compact('employees'));
  }

  public function create() {
    return view('admin.employee-add');
  }

  public function store(Request $request) {
    return 'test';

    $validatedData = $request->validate([
      'employee_first_name' => 'required|string|max:255',
      'employee_middle_name' => 'nullable|string|max:255',
      'employee_last_name' => 'required|string|max:255',
      'role' => 'required|string|max:255',
      'gender' => 'required|in:male,female,other',
      'birthday' => 'required|date',
      'email' => 'required|email|unique:employees_tbl,email',
      'phone' => 'required|string|max:11',
      'address' => 'required|string',
      'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('employee_image')) {
      $extension = $request->employee_image->extension();
      $imageName = str_replace(['@', '.'], '', $validatedData['email']) . '.' . $extension;
      $request->employee_image->move(public_path('images/employee-images'), $imageName);
      $validatedData['employee_image'] = $imageName;
    }

    $employee = new Employee($validatedData);
    $employee->save();

    return redirect('/admin/employees');
  }

  public function edit($id) {
    $employee = Employee::findOrFail($id);
    return view('admin.employee-edit', compact('employee'));
  }

  public function update(Request $request, $id) {
    return 'test';

    $employee = Employee::findOrFail($id);

    $validatedData = $request->validate([
      'employee_first_name' => 'required|string|max:255',
      'employee_middle_name' => 'nullable|string|max:255',
      'employee_last_name' => 'required|string|max:255',
      'role' => 'required|string|max:255',
      'gender' => 'required|in:male,female,other',
      'birthday' => 'required|date',
      'email' => 'required|email|unique:employees_tbl,email,' . $id . ',employee_id',
      'phone' => 'required|string|max:11',
      'address' => 'required|string',
      'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('employee_image')) {
      // Delete the old image if it exists
      if ($employee->employee_image) {
        $oldImagePath = public_path('images/employee-images/' . $employee->employee_image);
        if (file_exists($oldImagePath)) {
          unlink($oldImagePath);
        }
      }

      // Upload the new image
      $extension = $request->employee_image->extension();
      $imageName = $id . '.' . $extension;
      $request->employee_image->move(public_path('images/employee-images'), $imageName);
      $validatedData['employee_image'] = $imageName;
    }

    $employee->fill($validatedData);
    $employee->save();

    return back()->with('success', 'Employee updated successfully!');
  }
}
