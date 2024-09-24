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

        $validated = $request->validated();

        Doctor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'province_id' => $validated['province_id'],
            'district_id' => $validated['district_id'],
            'municipality_id' => $validated['municipality_id'],
            'department_id' => $validated['department_id'],
            'status' => $validated['status'],
            'date_of_birth_bs' => $validated['dob_bs'],
            'date_of_birth_ad' => $validated['dob_ad'],
        ]);

        // Save the user login info into the 'users' table
        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
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
        $validated = $request->validated();

        // Update only relevant fields
        $doctor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'province_id' => $validated['province_id'],
            'district_id' => $validated['district_id'],
            'municipality_id' => $validated['municipality_id'],
            'department_id' => $validated['department_id'],
            'status' => $validated['status'],
            'date_of_birth_bs' => $validated['dob_bs'],
            'date_of_birth_ad' => $validated['dob_ad'],
        ]);

        // Update user login info only if the password is provided
        if ($validated['password']) {
            DB::table('users')->where('email', $doctor->email)->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'remember_token' => $request->_token,
            ]);
        }

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
