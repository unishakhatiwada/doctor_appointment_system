<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentsDataTable;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
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
        return view('departments.create');
    }

    public function store(DepartmentStoreRequest $request): RedirectResponse
    {
        Department::create([
            'code' => $request['code'],
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Department $department):View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department):RedirectResponse
    {
        $department->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
