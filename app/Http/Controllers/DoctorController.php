<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentsDataTable;
use App\DataTables\DoctorsDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(DoctorsDataTable $dataTable)
    {
        return $dataTable->render('doctors.index');
    }

    public function create():View
    {
        $departments = Department::all();
        $provinces = DB::table('provinces')->get();

        return view('doctors.create', compact('departments','provinces'));
    }

    public function store(DoctorStoreRequest $request):RedirectResponse
    {
        Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor):View
    {

        $doctor->load('department');

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor):View
    {
        $departments = Department::all();

        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(DoctorUpdateRequest $request, Doctor $doctor):RedirectResponse
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index', $doctor->id)->with('success', 'Doctor updated successfully.');
    }

    public function assign(Doctor $doctor)
    {
        $departments = Department::all();

        return view('doctors.assign', compact('doctor', 'departments'));
    }

    public function destroy(Doctor $doctor):RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
