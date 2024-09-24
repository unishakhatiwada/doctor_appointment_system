@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <h1>{{ isset($doctor) ? 'Edit Doctor' : 'Add New Doctor' }}</h1>

        <form action="{{ isset($doctor) ? route('doctors.update', $doctor->id) : route('doctors.store') }}" method="POST">
            @csrf
            @if(isset($doctor))
                @method('PUT')
            @endif
            <!-- Doctor's Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label">Doctor's Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $doctor->name ?? '') }}"  required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $doctor->email ?? '') }}"  required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Input -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}"  required>
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if(!isset($doctor)) <!-- Only show these fields when creating a new doctor -->
            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                </div>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIconConfirm"></i>
                        </span>
                </div>
                @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @endif

            <!-- Province Selection -->
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select name="province_id" id="province" class="form-control">
                    <option value="">Select Province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}"
                            {{ old('province_id', $doctor->province_id ?? '') == $province->id ? 'selected' : '' }}>
                            {{ $province->nepali_name }}
                        </option>
                    @endforeach
                </select>
                @error('province_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- District Selection -->
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select name="district_id" id="district" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                    <option value="">Select District</option>
                    @if(isset($districts))
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ old('district_id', $doctor->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->district_nepali_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('district_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Municipality Selection -->
            <div class="mb-3">
                <label for="municipality" class="form-label">Municipality</label>
                <select name="municipality_id" id="municipality" class="form-control" {{ isset($doctor) ? '' : 'disabled' }}>
                    <option value="">Select Municipality</option>
                    @if(isset($municipalities))
                        @foreach($municipalities as $municipality)
                            <option value="{{ $municipality->id }}"
                                {{ old('municipality_id', $doctor->municipality_id ?? '') == $municipality->id ? 'selected' : '' }}>
                                {{ $municipality->muni_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('municipality_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- Department Selection -->
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department_id" id="department" class="form-control">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', $doctor->department_id ?? '') == $department->id ? 'selected' : '' }}>
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

            <!-- BS Date Input -->
            <div class="mb-3">
                <label for="dob_bs" class="form-label">Date of Birth (BS)</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="dob_bs" name="dob_bs" placeholder="YYYY/MM/DD" value="{{ old('dob_bs') }}" required>
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                @error('dob_bs')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- AD Date Input -->
            <div class="mb-3">
                <label for="dob_ad" class="form-label">Date of Birth (AD)</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="dob_ad" name="dob_ad" placeholder="YYYY-MM-DD" value="{{ old('dob_ad') }}" required>
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                @error('dob_ad')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($doctor) ? 'Update Doctor' : 'Add Doctor' }}</button>
        </form>
    </div>
    <script src="{{ asset('Admin/build/js/TogglePassword.js') }}"></script>
    <script src="{{ asset('Admin/build/js/AddressSelection.js') }}"></script>
@endsection
