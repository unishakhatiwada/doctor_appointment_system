<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
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

        return view('doctors.create_edit', compact('departments', 'provinces'));
    }

    public function store(DoctorStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Start transaction
        DB::beginTransaction();

        try {
            // Create the doctor record
            $doctor = Doctor::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'],
                'permanent_province_id' => $validated['permanent_province_id'],
                'permanent_district_id' => $validated['permanent_district_id'],
                'permanent_municipality_id' => $validated['permanent_municipality_id'],
                'temporary_province_id' => $validated['temporary_province_id'],
                'temporary_district_id' => $validated['temporary_district_id'],
                'temporary_municipality_id' => $validated['temporary_municipality_id'],
                'department_id' => $validated['department_id'],
                'status' => $validated['status'],
                'date_of_birth_bs' => $validated['dob_bs'],
                //                'date_of_birth_ad' => $validated['dob_ad'],
            ]);
            // Create the associated user record (
            DB::table('users')->insert([
                'name' => $doctor->name,
                'email' => $doctor->email,
                'password' => Hash::make($validated['password']),
                'remember_token' => $request->_token,
            ]);
            // Create the related education records
            if (isset($validated['education']) && is_array($validated['education'])) {
                $educationData = [];
                foreach ($validated['education'] as $education) {
                    $educationData[] = [
                        'degree' => $education['degree'],
                        'institute_name' => $education['institute_name'],
                        'institute_address' => $education['institute_address'],
                        'grade' => $education['grade'],
                        'faculty' => $education['faculty'],
                        'joining_date' => $education['joining_date'],
                        'graduation_date' => $education['graduation_date'],
                        'additional_detail' => $education['additional_detail'],
                        // 'certificate' => $education['education_certificate'],
                    ];
                }
                $doctor->educations()->createMany($educationData);
            }

            // Create the related experience records
            if (isset($validated['experience']) && is_array($validated['experience'])) {
                $experienceData = [];
                foreach ($validated['experience'] as $experience) {
                    $experienceData[] = [
                        'job_title' => $experience['job_title'],
                        'type_of_employment' => $experience['type_of_employment'],
                        'health_care_name' => $experience['health_care_name'],
                        'health_care_location' => $experience['health_care_location'],
                        'start_date' => $experience['start_date'],
                        'end_date' => $experience['end_date'],
                        'additional_detail' => $experience['additional_detail'],
                        // 'certificate' => $experience['experience_certificate'],
                    ];
                }
                $doctor->experiences()->createMany($experienceData);
            }

            // Commit transaction after saving doctor, educations, and experiences
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to create doctor. Please try again.');
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
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

        return view('doctors.create_edit', compact('doctor', 'departments', 'provinces', 'districts', 'municipalities'));

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
