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
                'date_of_birth_ad' => $validated['date_of_birth_ad'],
                'date_of_birth_bs' => $validated['date_of_birth_bs'],
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
        // Fetch permanent and temporary addresses using DB::table
        $permanentProvince = DB::table('provinces')->where('id', $doctor->permanent_province_id)->first();
        $permanentDistrict = DB::table('districts')->where('id', $doctor->permanent_district_id)->first();
        $permanentMunicipality = DB::table('municipalities')->where('id', $doctor->permanent_municipality_id)->first();

        $temporaryProvince = DB::table('provinces')->where('id', $doctor->temporary_province_id)->first();
        $temporaryDistrict = DB::table('districts')->where('id', $doctor->temporary_district_id)->first();
        $temporaryMunicipality = DB::table('municipalities')->where('id', $doctor->temporary_municipality_id)->first();

        // Load related department, educations, and experiences
        $doctor->load(['department', 'educations', 'experiences']);

        // Pass address details to the view
        return view('doctors.show', compact(
            'doctor',
            'permanentProvince', 'permanentDistrict', 'permanentMunicipality',
            'temporaryProvince', 'temporaryDistrict', 'temporaryMunicipality'
        ));
    }

    public function edit(Doctor $doctor): View
    {

        // Fetch all departments and provinces for dropdowns
        $departments = Department::all();
        $provinces = DB::table('provinces')->get();

        // Fetch districts and municipalities based on the doctor's permanent and temporary addresses
        $permanentDistricts = DB::table('districts')->where('province_id', $doctor->permanent_province_id)->get();
        $permanentMunicipalities = DB::table('municipalities')->where('district_id', $doctor->permanent_district_id)->get();

        $temporaryDistricts = DB::table('districts')->where('province_id', $doctor->temporary_province_id)->get();
        $temporaryMunicipalities = DB::table('municipalities')->where('district_id', $doctor->temporary_district_id)->get();

        // Pass all data to the view
        return view('doctors.create_edit', compact(
            'doctor', 'departments',
            'provinces', 'permanentDistricts',
            'permanentMunicipalities',
            'temporaryDistricts', 'temporaryMunicipalities'
        ));

    }

    public function update(DoctorUpdateRequest $request, Doctor $doctor): RedirectResponse
    {

        $validated = $request->validated();

        // Start transaction
        DB::beginTransaction();

        try {
            // Update the doctor record
            $doctor->update([
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
                'date_of_birth_bs' => $validated['date_of_birth_bs'],
                'date_of_birth_ad' => $validated['date_of_birth_ad'],
            ]);

            // Update the associated user record (if you have a users table)
            DB::table('users')
                ->where('email', $doctor->email)
                ->update([
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                ]);

            // Update the related education records
            if (isset($validated['education']) && is_array($validated['education'])) {
                $doctor->educations()->delete(); // Delete old education records
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
                    ];
                }
                $doctor->educations()->createMany($educationData);
            }

            // Update the related experience records
            if (isset($validated['experience']) && is_array($validated['experience'])) {
                $doctor->experiences()->delete(); // Delete old experience records
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
                    ];
                }
                $doctor->experiences()->createMany($experienceData);
            }

            // Commit transaction after updating doctor, educations, and experiences
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to update doctor. Please try again.');
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }


    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
