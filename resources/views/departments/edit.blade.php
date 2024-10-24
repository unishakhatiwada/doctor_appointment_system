
@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Department</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form for updating department -->
                        <form action="{{ route('departments.update', $department->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Department Code -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Department Code</label>
                                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $department->code) }}" required>
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Department Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $department->name) }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Department Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $department->description) }}</textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Save Changes Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

