@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Doctor</h1>

        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            <!-- Doctor's Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label">Doctor's Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address Input -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Input -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Department Selection -->
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department_id" id="department" class="form-control">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
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

            <button type="submit" class="btn btn-primary">Add Doctor</button>
        </form>
    </div>
@endsection
