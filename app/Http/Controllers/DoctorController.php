<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(DoctorsDataTable $dataTable)
    {
        return $dataTable->render('doctors.index');
    }

    public function create(): View
    {
        $departments = Department::all();
        $provinces = DB::table('provinces')->get();

        return view('doctors.create', compact('departments', 'provinces'));
    }

    public function store(DoctorStoreRequest $request): RedirectResponse
    {

        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'municipality_id' => $request->municipality_id,
            'department_id' => $request->department_id,
            'status' => $request->status,
            'date_of_birth_bs' => $request->dob_bs,
            'date_of_birth_ad' => $request->dob_ad,
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => $request->_token,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor): View
    {

        $doctor->load('department');

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {

        $departments = Department::all();
        $provinces = DB::table('provinces')->get();
        $districts = DB::table('districts')->where('province_id', $doctor->province_id)->get();
        $municipalities = DB::table('municipalities')->where('district_id', $doctor->district_id)->get();

        return view('doctors.create', compact('doctor', 'departments', 'provinces', 'districts', 'municipalities'));

    }

    public function update(DoctorUpdateRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'municipality_id' => $request->municipality_id,
            'department_id' => $request->department_id,
            'status' => $request->status,
            'date_of_birth_bs' => $request->dob_bs,
            'date_of_birth_ad' => $request->dob_ad,
        ]);

        DB::table('users')->where('email', $doctor->email)->update([
            'name' => $request->name,
            'remember_token' => $request->_token,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function assign(Doctor $doctor)
    {
        $departments = Department::all();

        return view('doctors.assign', compact('doctor', 'departments'));
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
