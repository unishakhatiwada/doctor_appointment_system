<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentsDataTable;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render('departments.index');
    }
    public function publicIndex(): View
    {
        $departments = Department::all();  // Fetch all departments
        return view('welcome', compact('departments'));  // Return to welcome view
    }
    public function create(): View
    {
        $doctors = Doctor::all();

        return view('departments.create', compact('doctors'));
    }

    public function store(DepartmentStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Request $request, Department $department): View
    {
        $query = $department->doctors();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }
        $doctors = $query->paginate(10);

        return view('departments.show', compact('department', 'doctors'));
    }

    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->only('name', 'code', 'description'));

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');

    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function addDoctorForm(Department $department): View
    {
        // Get all doctors who are not currently assigned to this department
        $doctors = Doctor::whereDoesntHave('department', function ($query) use ($department) {
            $query->where('id', $department->id);
        })->get();

        return view('departments.add-doctors', compact('department', 'doctors'));
    }

    public function addDoctors(Request $request, Department $department)
    {
        // Validate the incoming doctor_ids array
        $request->validate([
            'doctor_ids' => 'required|array',
            'doctor_ids.*' => 'exists:doctors,id',
        ]);

        // Get doctors not already assigned to the department or without a department
        Doctor::whereIn('id', $request->doctor_ids)
            ->where(function ($query) use ($department) {
                $query->whereNull('department_id') // Handle doctors with no department
                    ->orWhere('department_id', '!=', $department->id); // Handle doctors assigned to a different department
            })
            ->update(['department_id' => $department->id]);

        // Redirect back to the department's show page with a success message
        return redirect()->route('departments.show', $department->id)->with('success', 'Doctors added successfully.');
    }
}
