@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Doctor Details</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $doctor->name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                <p><strong>Address:</strong> {{ $doctor->address }}</p>
                <p><strong>Status:</strong> {{ $doctor->status }}</p>
                <p><strong>Department:</strong>
                    {{ $doctor->department ? $doctor->department->name : 'No department assigned' }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            @if($doctor->department_id)
                <!-- If department is assigned, show the view department button -->
                <a href="{{ route('departments.show', ['department' => $doctor->department_id]) }}" class="btn btn-secondary">
                    Dr. {{ $doctor->name }}'s Department
                </a>
            @else
                <!-- If no department is assigned, show the add department button -->
                <a href="{{ route('doctors.assign', $doctor->id) }}" class="btn btn-primary">Assign to Department</a>
            @endif

            <!-- Edit Doctor Button (always visible) -->
            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit Doctor</a>
        </div>
    </div>
@endsection
