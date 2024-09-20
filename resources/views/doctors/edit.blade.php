@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Doctor</h1>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $doctor->address) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $doctor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Department Assignment -->
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" class="form-control" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Save Button -->
            <button type="submit" class="btn btn-primary">Save Changes</button>

            <!-- Cancel Button -->
            <a href="{{ route('doctors.index', $doctor->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
