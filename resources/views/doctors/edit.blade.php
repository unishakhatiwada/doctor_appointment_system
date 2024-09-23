@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Doctor</h1>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <!-- Email Input -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Phone Input -->
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            <!-- Province Selection -->
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select name="province_id" id="province" class="form-control">
                    <option value="">Select Province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->nepali_name }}</option>
                    @endforeach
                </select>
                @error('province_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- District Selection -->
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select name="district_id" id="district" class="form-control" disabled>
                    <option value="">Select District</option>
                </select>
                @error('district_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Municipality Selection -->
            <div class="mb-3">
                <label for="municipality" class="form-label">Municipality</label>
                <select name="municipality_id" id="municipality" class="form-control" disabled>
                    <option value="">Select Municipality</option>
                </select>
                @error('municipality_id')
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

            <!-- Status Dropdown -->
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $doctor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
            </div>

            <!-- Department Dropdown -->
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" class="form-control" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('department_id'))
                    <span class="text-danger">{{ $errors->first('department_id') }}</span>
                @endif
            </div>

            <!-- Save Button -->
            <button type="submit" class="btn btn-primary">Save Changes</button>

            <!-- Cancel Button -->
            <a href="{{ route('doctors.index', $doctor->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
