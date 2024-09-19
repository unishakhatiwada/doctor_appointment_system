@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Assign Doctor to Department</h1>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT method for updating -->

            <div class="form-group">
                <label for="department_id">Select Department</label>
                <select name="department_id" class="form-control" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assign Doctor to Department Button -->
            <button type="submit" class="btn btn-primary">Assign Doctor</button>
            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection
