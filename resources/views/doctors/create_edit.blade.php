@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($doctor) ? 'Edit Doctor' : 'Create New Doctor' }}</h1>
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
                            <h3 class="card-title">{{ isset($doctor) ? 'Edit Doctor' : 'Create New Doctor' }}</h3>
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
                                    <div class="progress-bar" role="progressbar" style="width: 18rem;" id="progressBar">
                                    Step 1 of 4
                                    </div>
                                </div>

                                <!-- Step 1: Doctor Login Information -->
                                <div class="step" id="step1">
                                    <h4><i class="fas fa-user text-purple"></i> Step 1: Doctor Login Information</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Doctor's Name <i class="fas fa-user"></i></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ old('name', isset($doctor) ? $doctor->name : '') }}" required>
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email <i class="fas fa-envelope"></i></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="{{ old('email', isset($doctor) ? $doctor->email : '') }}" required>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Phone<i class="fas fa-phone-alt"></i></label>
                                                <input type="phone" class="form-control" id="phone" name="phone"
                                                       value="{{ old('phone', isset($doctor) ? $doctor->phone : '') }}" required>
                                                @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <!-- Only show password fields if creating a new doctor -->
                                            @if(!isset($doctor))
                                                <div class="form-group">
                                                    <label for="password">Password <i class="fas fa-lock"></i></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password" name="password" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                        </div>
                                                    </div>
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password <i class="fas fa-lock"></i></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                                                        </div>
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
                                    <h4><i class="fas fa-info-circle text-purple"></i> Step 2: Doctor Personal Information</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender <i class="fas fa-venus-mars"></i></label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="male" {{ old('gender', isset($doctor) && $doctor->gender == 'male' ? 'selected' : '') }}>Male</option>
                                                    <option value="female" {{ old('gender', isset($doctor) && $doctor->gender == 'female' ? 'selected' : '') }}>Female</option>
                                                    <option value="other" {{ old('gender', isset($doctor) && $doctor->gender == 'other' ? 'selected' : '') }}>Other</option>
                                                </select>
                                                @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="marital_status">Marital Status <i class="fas fa-ring"></i></label>
                                                <select class="form-control" name="marital_status" required>
                                                    <option value="single" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'single' ? 'selected' : '') }}>Single</option>
                                                    <option value="married" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'married' ? 'selected' : '') }}>Married</option>
                                                    <option value="divorced" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'divorced' ? 'selected' : '') }}>Divorced</option>
                                                    <option value="widowed" {{ old('marital_status', isset($doctor) && $doctor->marital_status == 'widowed' ? 'selected' : '') }}>Widowed</option>
                                                </select>
                                                @error('marital_status')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Permanent  Address -->
                                            <div class="form-group">
                                                <label for="permanent_address" class="text-pink">Permanent Address <i class="fas fa-home"></i></label>

                                                <!-- Province Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_province" class="form-label">Province</label>
                                                    <select name="permanent_province_id" id="permanent_province" class="form-control">
                                                        <option value="">Select Province</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}" {{ old('permanent_province_id', $doctor->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                                                {{ $province->nepali_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('permanent_province_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- District Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_district" class="form-label">District</label>
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
                                                    @error('permanent_district_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Municipality Selection -->
                                                <div class="mb-3">
                                                    <label for="permanent_municipality" class="form-label">Municipality</label>
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
                                                    @error('permanent_municipality_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="temporary_address" class="text-pink">Temporary Address <i class="fas fa-home"></i></label>

                                            <!-- Province Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_province" class="form-label">Province</label>
                                                <select name="temporary_province_id" id="temporary_province" class="form-control">
                                                    <option value="">Select Province</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ old('temporary_province_id', $doctor->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                                            {{ $province->nepali_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('temporary_province_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- District Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_district" class="form-label">District</label>
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
                                                @error('temporary_district_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Municipality Selection -->
                                            <div class="mb-3">
                                                <label for="temporary_municipality" class="form-label">Municipality</label>
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
                                                @error('temporary_municipality_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Date of Birth (BS) with Calendar Icon -->
                                            <div class="form-group">
                                                <label for="dob_bs">Date of Birth (BS)</label>
                                                <div class="input-group">
                                                    <input type="text" id="dob_bs" class="form-control nepali-date-picker" placeholder="YYYY/MM/DD">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i> <!-- Font Awesome calendar icon -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Date of Birth (AD) with Calendar Icon -->
                                            <div class="form-group">
                                                <label for="dob_ad">Date of Birth (AD)</label>
                                                <div class="input-group">
                                                    <input type="text" id="dob_ad" class="form-control" placeholder="YYYY-MM-DD">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                          <i class="fas fa-calendar-alt"></i> <!-- Font Awesome calendar icon -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Education Information (Repeater, Two-Column Layout) -->
                                <div class="step" id="step3" style="display:none;">
                                    <h4><i class="fas fa-graduation-cap text-purple"></i> Step 3: Education Information</h4>
                                    <div id="educationRepeater">
                                        <div class="repeater-section">
                                            <div class="row">
                                                <!-- Column 1 -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="degree">Degree <i class="fas fa-university"></i></label>
                                                        <select class="form-control" name="education[0][degree]" required>
                                                            <option value="+2">+2</option>
                                                            <option value="bachelor">Bachelor</option>
                                                            <option value="master">Master</option>
                                                            <option value="phd">PhD</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="college_name">College Name</label>
                                                        <input type="text" class="form-control" name="education[0][college_name]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="additional_detail">Additional Details</label>
                                                        <input type="text" class="form-control" name="education[0][additional_detail]" required>
                                                    </div>
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="college_address">College Address</label>
                                                        <input type="text" class="form-control" name="education[0][college_address]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="faculty">Faculty</label>
                                                        <input type="text" class="form-control" name="education[0][faculty]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="certificate">Certificate (PDF)</label>
                                                        <input type="file" class="form-control-file" name="education[0][certificate]" accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Remove button for the repeater -->
                                            <button type="button" class="remove-education btn btn-danger">Remove Education</button>
                                            <hr />
                                        </div>
                                    </div>
                                    <!-- Add More Education -->
                                    <button type="button" id="addEducation" class="btn btn-success">Add More Education</button>
                                </div>

                                <!-- Step 4: Experience Information (Repeater, Two-Column Layout) -->
                                <div class="step" id="step4" style="display:none;">
                                    <h4><i class="fas fa-briefcase text-purple"></i> Step 4: Experience Information</h4>

                                    <div id="experienceRepeater">
                                        <div class="repeater-section">
                                            <div class="row">
                                                <!-- Column 1 -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="job_title">Job Title <i class="fas fa-id-badge"></i></label>
                                                        <input type="text" class="form-control" name="experience[0][job_title]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="type_of_employment">Type of Employment <i class="fas fa-briefcase"></i></label>
                                                        <select class="form-control" name="experience[0][type_of_employment]" required>
                                                            <option value="full_time">Full-Time</option>
                                                            <option value="part_time">Part-Time</option>
                                                            <option value="contract">Contract</option>
                                                            <option value="internship">Internship</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="health_care_name">Healthcare Name</label>
                                                        <input type="text" class="form-control" name="experience[0][health_care_name]" required>
                                                    </div>
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="health_care_address">Healthcare Address</label>
                                                        <input type="text" class="form-control" name="experience[0][health_care_address]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="start_date">Start Date <i class="fas fa-calendar-alt"></i></label>
                                                        <input type="date" class="form-control" name="experience[0][start_date]" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="end_date">End Date <i class="fas fa-calendar-alt"></i></label>
                                                        <input type="date" class="form-control" name="experience[0][end_date]">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="additional_detail">Additional Details</label>
                                                <textarea class="form-control" name="experience[0][additional_detail]" rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="certificate">Certificate (PDF)</label>
                                                <input type="file" class="form-control-file" name="experience[0][certificate]" accept="application/pdf">
                                            </div>
                                            <!-- Remove button for the repeater -->
                                            <button type="button" class="remove-experience btn btn-danger">Remove</button>
                                            <hr />
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
