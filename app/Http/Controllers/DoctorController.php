<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DoctorController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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

            // Create the associated user record
            DB::table('users')->insert([
                'name' => $doctor->name,
                'email' => $doctor->email,
                'password' => Hash::make($validated['password']),
                'remember_token' => $request->_token,
            ]);

            // Create the related education records
            if (isset($validated['education']) && is_array($validated['education'])) {
                foreach ($validated['education'] as $education) {
                    // Create the education record first
                    $educationRecord = $doctor->educations()->create([
                        'degree' => $education['degree'],
                        'institute_name' => $education['institute_name'],
                        'institute_address' => $education['institute_address'],
                        'grade' => $education['grade'],
                        'faculty' => $education['faculty'],
                        'joining_date_bs' => $education['joining_date_bs'],
                        'joining_date_ad' => $education['joining_date_ad'],
                        'graduation_date_bs' => $education['graduation_date_bs'],
                        'graduation_date_ad' => $education['graduation_date_ad'],
                        'additional_detail' => $education['additional_detail'],
                    ]);

                    // Handle single file upload for education certificate using the FileUploadService
                    if (isset($education['certificate']) && $education['certificate']->isValid()) {
                        $filePath = $this->fileUploadService->handlePdfUpload(['content' => $education['certificate']]);
                        $educationRecord->update(['certificate' => $filePath]); // Update after the file is uploaded
                    }
                }
            }

            // Create the related experience records
            if (isset($validated['experience']) && is_array($validated['experience'])) {
                foreach ($validated['experience'] as $experience) {
                    // Create the experience record first
                    $experienceRecord = $doctor->experiences()->create([
                        'job_title' => $experience['job_title'],
                        'type_of_employment' => $experience['type_of_employment'],
                        'health_care_name' => $experience['health_care_name'],
                        'health_care_location' => $experience['health_care_location'],
                        'start_date_bs' => $experience['start_date_bs'],
                        'start_date_ad' => $experience['start_date_ad'],
                        'end_date_bs' => $experience['end_date_bs'],
                        'end_date_ad' => $experience['end_date_ad'],
                        'additional_detail' => $experience['additional_detail'],
                    ]);

                    // Handle single file upload for experience certificate using the FileUploadService
                    if (isset($experience['certificate']) && $experience['certificate']->isValid()) {
                        $filePath = $this->fileUploadService->handlePdfUpload(['content' => $experience['certificate']]);
                        $experienceRecord->update(['certificate' => $filePath]); // Update after the file is uploaded
                    }
                }
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

        // Fetch the doctor record
        $doctor = Doctor::with(['educations', 'experiences'])->findOrFail($doctor->id);
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
        DB::beginTransaction();

        try {
            // Update doctor record
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

            // Handle related education records
            if (isset($validated['education']) && is_array($validated['education'])) {
                foreach ($validated['education'] as $education) {
                    // Check if the record is marked as deleted
                    if (isset($education['deleted']) && $education['deleted'] == 1) {
                        // Delete the record if it exists in the database
                        if (isset($education['id'])) {
                            $doctor->educations()->where('id', $education['id'])->delete();
                        }

                        continue;  // Skip the rest of the processing for this record
                    }

                    // Check if the 'id' exists and is valid, update or create the education record
                    $educationRecord = $doctor->educations()->updateOrCreate(
                        ['id' => $education['id'] ?? null],  // Use the 'id' to find the record, if it exists
                        [
                            'degree' => $education['degree'],
                            'institute_name' => $education['institute_name'],
                            'institute_address' => $education['institute_address'],
                            'grade' => $education['grade'],
                            'faculty' => $education['faculty'],
                            'joining_date_bs' => $education['joining_date_bs'],
                            'joining_date_ad' => $education['joining_date_ad'],
                            'graduation_date_bs' => $education['graduation_date_bs'],
                            'graduation_date_ad' => $education['graduation_date_ad'],
                            'additional_detail' => $education['additional_detail'],
                        ]
                    );

                    // Handle file deletion if delete checkbox is selected
                    if (isset($education['delete_certificate']) && $education['delete_certificate'] == 1) {
                        if ($educationRecord->certificate) {
                            Storage::disk('public')->delete(str_replace('/storage/', '', $educationRecord->certificate));
                            $educationRecord->update(['certificate' => null]);
                        }
                    }

                    // Handle file upload for education certificate if a new file is provided
                    if (isset($education['certificate']) && $education['certificate']->isValid()) {
                        $filePath = $this->fileUploadService->handlePdfUpload(['content' => $education['certificate']], 'education_certificates');
                        $educationRecord->update(['certificate' => $filePath]);
                    }
                }
            }

            // Handle related experience records
            if (isset($validated['experience']) && is_array($validated['experience'])) {
                foreach ($validated['experience'] as $experience) {
                    // Check if the record is marked as deleted
                    if (isset($experience['deleted']) && $experience['deleted'] == 1) {
                        // Delete the record if it exists in the database
                        if (isset($experience['id'])) {
                            $doctor->experiences()->where('id', $experience['id'])->delete();
                        }

                        continue;  // Skip the rest of the processing for this record
                    }

                    // Check if the 'id' exists and is valid, update or create the experience record
                    $experienceRecord = $doctor->experiences()->updateOrCreate(
                        ['id' => $experience['id'] ?? null],  // Use the 'id' to find the record, if it exists
                        [
                            'job_title' => $experience['job_title'],
                            'type_of_employment' => $experience['type_of_employment'],
                            'health_care_name' => $experience['health_care_name'],
                            'health_care_location' => $experience['health_care_location'],
                            'start_date_bs' => $experience['start_date_bs'],
                            'start_date_ad' => $experience['start_date_ad'],
                            'end_date_bs' => $experience['end_date_bs'],
                            'end_date_ad' => $experience['end_date_ad'],
                            'additional_detail' => $experience['additional_detail'],
                        ]
                    );

                    // Handle file deletion if delete checkbox is selected
                    if (isset($experience['delete_certificate']) && $experience['delete_certificate'] == 1) {
                        if ($experienceRecord->certificate) {
                            Storage::disk('public')->delete(str_replace('/storage/', '', $experienceRecord->certificate));
                            $experienceRecord->update(['certificate' => null]);
                        }
                    }

                    // Handle file upload for experience certificate if a new file is provided
                    if (isset($experience['certificate']) && $experience['certificate']->isValid()) {
                        $filePath = $this->fileUploadService->handlePdfUpload(['content' => $experience['certificate']], 'experience_certificates');
                        $experienceRecord->update(['certificate' => $filePath]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to update doctor. Please try again.');
        }
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
