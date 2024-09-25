@extends('admin.layouts.app')
@php
    function requiredField($isRequired = false) {
        return $isRequired ? '<span class="text-danger">*</span>' : '';
    }
@endphp

@section('content')
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
                                                <div class="form-group">
                                                    <label for="password">Password <i class="fas fa-lock"></i>{!! requiredField(true) !!}</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password" name="password" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                        </div>
                                                        <div class="invalid-feedback">Please fill the password field</div>
                                                    </div>
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password <i class="fas fa-lock"></i>{!! requiredField(true) !!}</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                        </div>
                                                        <div class="invalid-feedback">Please fill the confirm password field</div>
                                                    </div>
                                                    @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
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


                                            <!-- Permanent  Address -->
                                            <div class="form-group">
                                                <label for="permanent_address" class="text-pink">Permanent Address <i class="fas fa-home"></i>{!! requiredField(true) !!}</label>

                                                <!-- Province Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_province" class="form-label">Province {!! requiredField(true) !!}</label>
                                                    <select name="permanent_province_id" id="permanent_province" class="form-control">
                                                        <option value="">Select Province</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}" {{ old('permanent_province_id', $doctor->province_id ?? '') == $province->id ? 'selected' : '' }}>
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
                                                        @if(isset($districts))
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" {{ old('permanent_district_id', $doctor->district_id ?? '') == $district->id ? 'selected' : '' }}>
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
                                                        @if(isset($municipalities))
                                                            @foreach($municipalities as $municipality)
                                                                <option value="{{ $municipality->id }}" {{ old('permanent_municipality_id', $doctor->municipality_id ?? '') == $municipality->id ? 'selected' : '' }}>
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
                                            <label for="temporary_address" class="text-pink">Temporary Address <i class="fas fa-home"></i> {!! requiredField(true) !!}</label>

                                            <!-- Province Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_province" class="form-label">Province {!! requiredField(true) !!}</label>
                                                <select name="temporary_province_id" id="temporary_province" class="form-control">
                                                    <option value="">Select Province</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ old('temporary_province_id', $doctor->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                                            {{ $province->nepali_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select a Province.</div>
                                                @error('temporary_province_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- District Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_district" class="form-label">District {!! requiredField(true) !!}</label>
                                                <select name="temporary_district_id" id="temporary_district" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                    <option value="">Select District</option>
                                                    @if(isset($districts))
                                                        @foreach($districts as $district)
                                                            <option value="{{ $district->id }}" {{ old('temporary_district_id', $doctor->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                                                {{ $district->district_nepali_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback">Please select a District.</div>
                                                @error('temporary_district_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Municipality Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_municipality" class="form-label">Municipality {!! requiredField(true) !!}</label>
                                                <select name="temporary_municipality_id" id="temporary_municipality" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                                                    <option value="">Select Municipality</option>
                                                    @if(isset($municipalities))
                                                        @foreach($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}" {{ old('temporary_municipality_id', $doctor->municipality_id ?? '') == $municipality->id ? 'selected' : '' }}>
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

                                            <!-- Date of Birth (BS) with Calendar Icon -->
                                            <div class="form-group">
                                                <label for="dob_bs">Date of Birth (BS) {!! requiredField(true) !!}</label>
                                                <div class="input-group">
                                                    <input type="text" id="dob_bs" name="dob_bs" class="form-control nepali-date-picker" placeholder="YYYY/MM/DD" value="{{ old('dob_bs', isset($doctor) ? $doctor->dob_bs : '') }}" required>
                                                    <div class="input-group-append">
                                                         <span class="input-group-text">
                                                             <i class="fas fa-calendar-alt"></i>
                                                         </span>
                                                    </div>
                                                    <div class="invalid-feedback">Please select a valid Date of Birth in BS.</div>
                                                    @error('dob_bs')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Date of Birth (AD) with Calendar Icon -->
                                            <div class="form-group">
                                                <label for="dob_ad">Date of Birth (AD) {!! requiredField(true) !!}</label>
                                                <div class="input-group">
                                                    <input type="text" id="dob_ad" name="dob_ad" class="form-control" placeholder="YYYY-MM-DD" value="{{ old('dob_ad', isset($doctor) ? $doctor->dob_ad : '') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <div class="invalid-feedback">Please select a valid Date of Birth in AD.</div>
                                                    @error('dob_ad')
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
                                                        <label for="college_name">College Name  {!! requiredField(true) !!}</label>
                                                        <input type="text" class="form-control" name="education[0][college_name]" required>
                                                        <div class="invalid-feedback">Please fill the College Name</div>
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
                                                        <label for="college_address">College Address  {!! requiredField(true) !!}</label>
                                                        <input type="text" class="form-control" name="education[0][college_address]" required>
                                                        <div class="invalid-feedback">Please fill the College Address</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="faculty">Faculty  {!! requiredField(true) !!}</label>
                                                        <input type="text" class="form-control" name="education[0][faculty]" required>
                                                        <div class="invalid-feedback">Please fill the Faculty Name</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="education_start_date">Start Date <i class="fas fa-calendar-alt"></i> {!! requiredField(true) !!}</label>
                                                        <input type="date" class="form-control" name="education[0][start_date]" required>
                                                        <div class="invalid-feedback">Please fill the valid date</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="education_end_date">End Date <i class="fas fa-calendar-alt"></i> {!! requiredField(true) !!}</label>
                                                        <input type="date" class="form-control" name="education[0][end_date]" required>
                                                        <div class="invalid-feedback">Please fill the valid date</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add More Education -->
                                    <button type="button" id="addEducation" class="btn btn-success">Add More Education</button>
                                </div>

                                <!-- Step 4: Experience Information (Repeater, Two-Column Layout) -->
                                <div class="step" id="step4" style="display:none;">
                                    <h4 class="text-center text-bold text-teal"><i class="fas fa-briefcase text-pink"></i> Step 4: Experience Information</h4>

                                    <div id="experienceRepeater">
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
                                                        <label for="health_care_name">Healthcare Name  {!! requiredField(true) !!}</label>
                                                        <input type="text" class="form-control" name="experience[0][health_care_name]" required>
                                                        <div class="invalid-feedback">Please fill Healthcare Name field</div>
                                                    </div>
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="health_care_address">Healthcare Address  {!! requiredField(true) !!}</label>
                                                        <input type="text" class="form-control" name="experience[0][health_care_address]" required>
                                                        <div class="invalid-feedback">Please fill Healthcare Address field</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="experience_start_date">Start Date  {!! requiredField(true) !!} <i class="fas fa-calendar-alt"></i></label>
                                                        <input type="date" class="form-control" name="experience[0][start_date]" required>
                                                        <div class="invalid-feedback">Please fill Start Date field</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="experience_end_date">End Date  {!! requiredField(true) !!} <i class="fas fa-calendar-alt"></i></label>
                                                        <input type="date" class="form-control" name="experience[0][end_date]">
                                                        <div class="invalid-feedback">Please fill End Date field</div>
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
                                    </div>

                                    <!-- Add More Experience -->
                                    <button type="button" id="addExperience" class="btn btn-secondary">Add More Experience</button>
                                </div>


                                <div class="card-footer">
                                    <button type="button" class="btn btn-secondary" id="prevBtn" style="display:none;">Previous</button>
                                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                                    <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">Submit</button>
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
        <script src="{{ asset('Admin/build/js/TogglePassword.js') }}"></script>
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
