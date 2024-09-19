<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentsDataTable;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render('departments.index');
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

    public function show(Department $department): View
    {
        $doctors = $department->doctors()->get();
        return view('departments.show', compact('department' , 'doctors'));
    }

    public function edit(Department $department):View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department):RedirectResponse
    {
        $department->update($request->only('name', 'code', 'description'));

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');

    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
