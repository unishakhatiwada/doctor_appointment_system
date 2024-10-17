@extends('admin.layouts.app')
@php
    function requiredField($isRequired = false) {
        return $isRequired ? '<span class="text-danger">*</span>' : '';
    }
@endphp

@section('content')
    {{$errors}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-blue">{{ isset($doctor) ? 'Edit Doctor' : 'Create New Doctor' }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Multi-Step Form -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title text-purple">{{ isset($doctor) ? 'Edit Doctor' : 'Create New Doctor' }}</h3>
                        </div>
                        <form id="multiStepForm"
                              action="{{ isset($doctor) ? route('doctors.update', $doctor->id) : route('doctors.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <!-- If editing, use PUT method -->
                            @if(isset($doctor))
                                @method('PUT')
                            @endif

                            <!-- Hidden Input to Track Current Step -->
                            <input type="hidden" id="currentStepInput" name="step" value="doctor_info">

                            <div class="card-body">
                                <div class="progress mb-4" style="height: 30px;">
                                    <div class="progress-bar bg-olive" role="progressbar" style="width: 10%;" id="progressBar">
                                        Step 1 of 4
                                    </div>
                                </div>

                                <!-- Step 1: Doctor Login Information -->
                                <div class="step" id="step1">
                                    <h4 class="text-center text-bold text-teal"><i class="fas fa-user text-pink"></i> Step 1: Doctor Login Information</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Doctor's Name <i class="fas fa-user"></i> {!! requiredField(true) !!}</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ old('name', isset($doctor) ? $doctor->name : '') }}" required>
                                                <div class="invalid-feedback">Please fill the Doctor's Name field</div>
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        <div class="form-group">
                                                <label for="email">Email <i class="fas fa-envelope"></i>{!! requiredField(true) !!}</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="{{ old('email', isset($doctor) ? $doctor->email : '') }}" required>
                                            <div class="invalid-feedback">Please fill the Email Address field</div>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <!-- Only show password fields if creating a new doctor -->
                                            @if(!isset($doctor))
                                                <div class="col-md-6">
                                                    <!-- Password Field -->
                                                    <div class="form-group">
                                                        <label for="password">Password <i class="fas fa-lock"></i>{!! requiredField(true) !!}</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="password" name="password" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                            </div>
                                                            <div class="invalid-feedback">Please fill the password field.</div> <!-- This will show at the bottom -->
                                                        </div>
                                                    </div>

                                                    <!-- Confirm Password Field -->
                                                    <div class="form-group">
                                                        <label for="password_confirmation">Confirm Password <i class="fas fa-lock"></i>{!! requiredField(true) !!}</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                            </div>
                                                            <div class="invalid-feedback">Please confirm your password.</div> <!-- This will show at the bottom -->
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Doctor Personal Information -->
                                <div class="step" id="step2" style="display:none;">
                                    <h4 class="text-center text-bold text-teal"><i class="fas fa-info-circle text-pink"></i> Step 2: Doctor Personal Information</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender <i class="fas fa-venus-mars"></i> {!! requiredField(true) !!}</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="male" {{ old('gender', isset($doctor) && $doctor->gender == 'male' ? 'selected' : '') }}>Male</option>
                                                    <option value="female" {{ old('gender', isset($doctor) && $doctor->gender == 'female' ? 'selected' : '') }}>Female</option>
                                                    <option value="other" {{ old('gender', isset($doctor) && $doctor->gender == 'other' ? 'selected' : '') }}>Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the Gender</div>
                                                @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="marital_status">Marital Status <i class="fas fa-ring"></i> {!! requiredField(true) !!}</label>
                                                <select class="form-control" name="marital_status" required>
                                                    <option value="single" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'single' ? 'selected' : '') }}>Single</option>
                                                    <option value="married" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'married' ? 'selected' : '') }}>Married</option>
                                                    <option value="divorced" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'divorced' ? 'selected' : '') }}>Divorced</option>
                                                    <option value="widowed" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'widowed' ? 'selected' : '') }}>Widowed</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the Marital Status</div>
                                                @error('marital_status')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- Phone number--}}
                                            <div class="form-group">
                                                <label for="phone">Phone <i class="fas fa-phone-alt"></i>{!! requiredField(true) !!}</label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                       value="{{ old('phone', isset($doctor) ? $doctor->phone : '') }}" required
                                                       pattern="^\d{10}$"
                                                       maxlength="10"
                                                       title="Please enter a valid 10-digit phone number">
                                                <div class="invalid-feedback">Please fill the phone field</div>
                                                @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Permanent Address -->
                                            <div class="form-group">
                                                <label for="permanent_address" class="text-pink">Permanent Address <i class="fas fa-home"></i>{!! requiredField(true) !!}</label>

                                                <!-- Province Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_province" class="form-label">Province {!! requiredField(true) !!}</label>
                                                    <select name="permanent_province_id" id="permanent_province" class="form-control">
                                                        <option value="">Select Province</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}" {{ old('permanent_province_id', isset($doctor) ? $doctor->permanent_province_id : '') == $province->id ? 'selected' : '' }}>
                                                                {{ $province->nepali_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select a Province</div>
                                                    @error('permanent_province_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- District Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_district" class="form-label">District {!! requiredField(true) !!}</label>
                                                    <select name="permanent_district_id" id="permanent_district" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                        <option value="">Select District</option>
                                                        @if(isset($permanentDistricts) && $permanentDistricts->count() > 0)
                                                            @foreach($permanentDistricts as $district)
                                                                <option value="{{ $district->id }}" {{ old('permanent_district_id', isset($doctor) ? $doctor->permanent_district_id : '') == $district->id ? 'selected' : '' }}>
                                                                    {{ $district->district_nepali_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Please select a District</div>
                                                    @error('permanent_district_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Municipality Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_municipality" class="form-label">Municipality {!! requiredField(true) !!}</label>
                                                    <select name="permanent_municipality_id" id="permanent_municipality" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                        <option value="">Select Municipality</option>
                                                        @if(isset($permanentMunicipalities) && $permanentMunicipalities->count() > 0)
                                                            @foreach($permanentMunicipalities as $municipality)
                                                                <option value="{{ $municipality->id }}" {{ old('permanent_municipality_id', isset($doctor) ? $doctor->permanent_municipality_id : '') == $municipality->id ? 'selected' : '' }}>
                                                                    {{ $municipality->muni_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                                    @error('permanent_municipality_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <!-- Date of Birth (BS) with Calendar Icon -->
                                            <div class="form-group">
                                                <label for="date_of_birth_bs">Date of Birth (BS) {!! requiredField(true) !!}</label>
                                                <div class="input-group">
                                                    <input type="text" id="date_of_birth_bs" name="date_of_birth_bs" class="form-control nepali-date-picker" placeholder="YYYY/MM/DD"
                                                           value="{{ old('date_of_birth_bs', isset($doctor) ? $doctor->date_of_birth_bs : '') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                             <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <div class="invalid-feedback">Please select a valid Date of Birth in BS.</div>
                                                    @error('date_of_birth_bs')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Hidden field to store AD date -->
                                                <input type="hidden" id="date_of_birth_ad" name="date_of_birth_ad" value="{{ old('date_of_birth_ad', isset($doctor) ? $doctor->date_of_birth_ad : '') }}">
                                            </div>


                                            <!-- Department Selection -->
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <select name="department_id" id="department" class="form-control">
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ old('department_id', $doctor->department_id ?? '') === $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Status Selection -->
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Temporary Address -->
                                            <div class="form-group">
                                                <label for="temporary_address" class="text-pink">Temporary Address <i class="fas fa-home"></i> {!! requiredField(true) !!}</label>

                                                <!-- Province Selection -->
                                                <div class="mb-3">
                                                    <label for="temporary_province" class="form-label">Province {!! requiredField(true) !!}</label>
                                                    <select name="temporary_province_id" id="temporary_province" class="form-control">
                                                        <option value="">Select Province</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}" {{ old('temporary_province_id', isset($doctor) ? $doctor->temporary_province_id : '') == $province->id ? 'selected' : '' }}>
                                                                {{ $province->nepali_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select a Province</div>
                                                    @error('temporary_province_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- District Selection -->
                                                <div class="mb-3">
                                                    <label for="temporary_district" class="form-label">District {!! requiredField(true) !!}</label>
                                                    <select name="temporary_district_id" id="temporary_district" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                        <option value="">Select District</option>
                                                        @if(isset($temporaryDistricts) && $temporaryDistricts->count() > 0)
                                                            @foreach($temporaryDistricts as $district)
                                                                <option value="{{ $district->id }}" {{ old('temporary_district_id', isset($doctor) ? $doctor->temporary_district_id : '') == $district->id ? 'selected' : '' }}>
                                                                    {{ $district->district_nepali_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Please select a District</div>
                                                    @error('temporary_district_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Municipality Selection -->
                                                <div class="mb-3">
                                                    <label for="temporary_municipality" class="form-label">Municipality {!! requiredField(true) !!}</label>
                                                    <select name="temporary_municipality_id" id="temporary_municipality" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                        <option value="">Select Municipality</option>
                                                        @if(isset($temporaryMunicipalities) && $temporaryMunicipalities->count() > 0)
                                                            @foreach($temporaryMunicipalities as $municipality)
                                                                <option value="{{ $municipality->id }}" {{ old('temporary_municipality_id', isset($doctor) ? $doctor->temporary_municipality_id : '') == $municipality->id ? 'selected' : '' }}>
                                                                    {{ $municipality->muni_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                                    @error('temporary_municipality_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                    </div>
                                    </div>
                                </div>

                                <!-- Step 3: Education Information (Repeater, Two-Column Layout) -->
                                <div class="step" id="step3" style="display:none;">
                                    <h4 class="text-center text-bold text-teal"><i class="fas fa-graduation-cap text-pink"></i> Step 3: Education Information</h4>

                                    <div id="educationRepeater">
                                        @if(isset($doctor) && $doctor->educations)
                                            @foreach($doctor->educations as $index => $education)
                                                <div class="repeater-section">
                                                    <div class="row">
                                                        <!-- Column 1 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="degree">Degree <i class="fas fa-university"></i> {!! requiredField(true) !!}</label>
                                                                <select class="form-control" name="education[{{ $index }}][degree]" required>
                                                                    <option value="+2" {{ $education->degree == '+2' ? 'selected' : '' }}>+2</option>
                                                                    <option value="bachelor" {{ $education->degree == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                                                                    <option value="master" {{ $education->degree == 'master' ? 'selected' : '' }}>Master</option>
                                                                    <option value="phd" {{ $education->degree == 'phd' ? 'selected' : '' }}>PhD</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="institute_name">Institute Name {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][institute_name]" value="{{ old('education.'.$index.'.institute_name', $education->institute_name) }}" required>
                                                                <div class="invalid-feedback">Please fill the Institute Name</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="education_certificate">Certificate (PDF)</label>
                                                                <input type="file" class="form-control-file" name="education[{{ $index }}][certificate]" accept="application/pdf">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="education_additional_detail">Additional Details</label>
                                                                <textarea class="form-control" name="education[{{ $index }}][additional_detail]" rows="2">{{ old('education.'.$index.'.additional_detail', $education->additional_detail) }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Column 2 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="institute_address">Institute Address {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][institute_address]" value="{{ old('education.'.$index.'.institute_address', $education->institute_address) }}" required>
                                                                <div class="invalid-feedback">Please fill the Institute Address</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="faculty">Faculty {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][faculty]" value="{{ old('education.'.$index.'.faculty', $education->faculty) }}" required>
                                                                <div class="invalid-feedback">Please fill the Faculty Name</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="joining_date">Joining Date <i class="fas fa-calendar-alt"></i> {!! requiredField(true) !!}</label>
                                                                <input type="date" class="form-control" name="education[{{ $index }}][joining_date]" value="{{ old('education.'.$index.'.joining_date', $education->joining_date) }}" required>
                                                                <div class="invalid-feedback">Please fill the valid Joining Date</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="graduation_date">Graduation Date <i class="fas fa-calendar-alt"></i></label>
                                                                <input type="date" class="form-control" name="education[{{ $index }}][graduation_date]" value="{{ old('education.'.$index.'.graduation_date', $education->graduation_date) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="grade">Grade (GPA) {!! requiredField(true) !!}</label>
                                                                <input type="number" class="form-control" name="education[{{ $index }}][grade]" value="{{ old('education.'.$index.'.grade', $education->grade) }}" required min="0" max="4" step="0.1">
                                                                <div class="invalid-feedback">Please fill the Grade Field</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Remove button for the repeater -->
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="remove-education btn btn-danger">Remove Education</button>
                                                    </div>
                                                    <hr />
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default section when creating a new doctor -->
                                            <div class="repeater-section">
                                                <div class="row">
                                                    <!-- Column 1 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="degree">Degree <i class="fas fa-university"></i> {!! requiredField(true) !!}</label>
                                                            <select class="form-control" name="education[0][degree]" required>
                                                                <option value="+2">+2</option>
                                                                <option value="bachelor">Bachelor</option>
                                                                <option value="master">Master</option>
                                                                <option value="phd">PhD</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="institute_name">Institute Name {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="education[0][institute_name]" required>
                                                            <div class="invalid-feedback">Please fill the Institute Name</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="education_certificate">Certificate (PDF)</label>
                                                            <input type="file" class="form-control-file" name="education[0][certificate]" accept="application/pdf">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="education_additional_detail">Additional Details</label>
                                                            <textarea class="form-control" name="education[0][additional_detail]" rows="2"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Column 2 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="institute_address">Institute Address {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="education[0][institute_address]" required>
                                                            <div class="invalid-feedback">Please fill the Institute Address</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="faculty">Faculty {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="education[0][faculty]" required>
                                                            <div class="invalid-feedback">Please fill the Faculty Name</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="joining_date">Joining Date <i class="fas fa-calendar-alt"></i> {!! requiredField(true) !!}</label>
                                                            <input type="date" class="form-control" name="education[0][joining_date]" required>
                                                            <div class="invalid-feedback">Please fill the valid Joining Date</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="graduation_date">Graduation Date <i class="fas fa-calendar-alt"></i></label>
                                                            <input type="date" class="form-control" name="education[0][graduation_date]">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="grade">Grade (GPA) {!! requiredField(true) !!}</label>
                                                            <input type="number" class="form-control" name="education[0][grade]" required min="0" max="4" step="0.1">
                                                            <div class="invalid-feedback">Please fill the Grade Field</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Add More Education Button -->
                                    <button type="button" id="addEducation" class="btn btn-success">Add More Education</button>
                                </div>

                                <!-- Step 4: Experience Information (Repeater, Two-Column Layout) -->
                                <div class="step" id="step4" style="display:none;">
                                    <h4 class="text-center text-bold text-teal"><i class="fas fa-briefcase text-pink"></i> Step 4: Experience Information</h4>

                                    <div id="experienceRepeater">
                                        @if(isset($doctor) && $doctor->experiences)
                                            @foreach($doctor->experiences as $index => $experience)
                                                <div class="repeater-section">
                                                    <div class="row">
                                                        <!-- Column 1 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="job_title">Job Title <i class="fas fa-id-badge"></i> {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="experience[{{ $index }}][job_title]" value="{{ old('experience.'.$index.'.job_title', $experience->job_title) }}" required>
                                                                <div class="invalid-feedback">Please fill Job Title field</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="type_of_employment">Type of Employment <i class="fas fa-briefcase"></i> {!! requiredField(true) !!}</label>
                                                                <select class="form-control" name="experience[{{ $index }}][type_of_employment]" required>
                                                                    <option value="full_time" {{ $experience->type_of_employment == 'full_time' ? 'selected' : '' }}>Full-Time</option>
                                                                    <option value="part_time" {{ $experience->type_of_employment == 'part_time' ? 'selected' : '' }}>Part-Time</option>
                                                                    <option value="contract" {{ $experience->type_of_employment == 'contract' ? 'selected' : '' }}>Contract</option>
                                                                    <option value="internship" {{ $experience->type_of_employment == 'internship' ? 'selected' : '' }}>Internship</option>
                                                                </select>
                                                                <div class="invalid-feedback">Please select Type of Employment</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="health_care_name">Healthcare Name {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="experience[{{ $index }}][health_care_name]" value="{{ old('experience.'.$index.'.health_care_name', $experience->health_care_name) }}" required>
                                                                <div class="invalid-feedback">Please fill Healthcare Name field</div>
                                                            </div>
                                                        </div>

                                                        <!-- Column 2 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="health_care_location">Healthcare Location {!! requiredField(true) !!}</label>
                                                                <input type="text" class="form-control" name="experience[{{ $index }}][health_care_location]" value="{{ old('experience.'.$index.'.health_care_location', $experience->health_care_location) }}" required>
                                                                <div class="invalid-feedback">Please fill Healthcare Location field</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="experience_start_date">Start Date {!! requiredField(true) !!} <i class="fas fa-calendar-alt"></i></label>
                                                                <input type="date" class="form-control" name="experience[{{ $index }}][start_date]" value="{{ old('experience.'.$index.'.start_date', $experience->start_date) }}" required>
                                                                <div class="invalid-feedback">Please fill Start Date field</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="experience_end_date">End Date <i class="fas fa-calendar-alt"></i></label>
                                                                <input type="date" class="form-control" name="experience[{{ $index }}][end_date]" value="{{ old('experience.'.$index.'.end_date', $experience->end_date) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="experience_additional_detail">Additional Details</label>
                                                        <textarea class="form-control" name="experience[{{ $index }}][additional_detail]" rows="2">{{ old('experience.'.$index.'.additional_detail', $experience->additional_detail) }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="experience_certificate">Certificate (PDF)</label>
                                                        <input type="file" class="form-control-file" name="experience[{{ $index }}][certificate]" accept="application/pdf">
                                                    </div>

                                                    <!-- Remove button for the repeater -->
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="remove-experience btn btn-danger">Remove Experience</button>
                                                    </div>
                                                    <hr />
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default section when creating a new doctor -->
                                            <div class="repeater-section">
                                                <div class="row">
                                                    <!-- Column 1 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="job_title">Job Title <i class="fas fa-id-badge"></i> {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="experience[0][job_title]" required>
                                                            <div class="invalid-feedback">Please fill Job Title field</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="type_of_employment">Type of Employment <i class="fas fa-briefcase"></i> {!! requiredField(true) !!}</label>
                                                            <select class="form-control" name="experience[0][type_of_employment]" required>
                                                                <option value="full_time">Full-Time</option>
                                                                <option value="part_time">Part-Time</option>
                                                                <option value="contract">Contract</option>
                                                                <option value="internship">Internship</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select Type of Employment</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="health_care_name">Healthcare Name {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="experience[0][health_care_name]" required>
                                                            <div class="invalid-feedback">Please fill Healthcare Name field</div>
                                                        </div>
                                                    </div>

                                                    <!-- Column 2 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="health_care_location">Healthcare Location {!! requiredField(true) !!}</label>
                                                            <input type="text" class="form-control" name="experience[0][health_care_location]" required>
                                                            <div class="invalid-feedback">Please fill Healthcare Location field</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="experience_start_date">Start Date {!! requiredField(true) !!} <i class="fas fa-calendar-alt"></i></label>
                                                            <input type="date" class="form-control" name="experience[0][start_date]" required>
                                                            <div class="invalid-feedback">Please fill Start Date field</div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="experience_end_date">End Date <i class="fas fa-calendar-alt"></i></label>
                                                            <input type="date" class="form-control" name="experience[0][end_date]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="experience_additional_detail">Additional Details</label>
                                                    <textarea class="form-control" name="experience[0][additional_detail]" rows="2"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="experience_certificate">Certificate (PDF)</label>
                                                    <input type="file" class="form-control-file" name="experience[0][certificate]" accept="application/pdf">
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Add More Experience -->
                                    <button type="button" id="addExperience" class="btn btn-success">Add More Experience</button>
                                </div>



                                <div class="card-footer">
                                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back to List</a>
                                    <button type="button" class="btn btn-primary" id="prevBtn" style="display:none;">Previous</button>
                                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
{{--        Toggle password visibility--}}
        <script src="{{ asset('Admin/build/js/PasswordValidation.js') }}"></script>
{{--        address verification--}}
        <script src="{{asset('Admin/build/js/AddressSelection.js')}}"></script>
{{--        date conversion--}}
        <script src="{{asset('Admin/build/js/DateConversion.js')}}"></script>
{{--        Multi-Step Form Logic--}}
        <script src="{{asset('Admin/build/js/StepNavigation.js')}}"></script>
{{--        Education Repeator--}}
        <script src="{{asset('Admin/build/js/EducationRepeater.js')}}"></script>
{{--        Experience Repeator--}}
        <script src="{{asset('Admin/build/js/ExperienceRepeater.js')}}"></script>

    @endpush
@endsection
