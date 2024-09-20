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

            <!-- Address Input -->
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $doctor->address) }}" required>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
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
