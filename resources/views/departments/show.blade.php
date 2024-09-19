@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Department Details</h1>

        <!-- Department Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>{{ $department->name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Code:</strong> {{ $department->code }}</p>
                <p><strong>Description:</strong> {{ $department->description ?? 'No description available' }}</p>
            </div>
        </div>

        <!-- Search Doctors by Name -->
        <form method="GET" action="{{ route('departments.show', $department->id) }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search doctors by name" value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <!-- Associated Doctors in Table -->
        <div class="card">
            <div class="card-header">
                <h3>Doctors in {{ $department->name }}</h3>
            </div>
            <div class="card-body">
                @if($doctors->isEmpty())
                    <p>No doctors assigned to this department.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ $doctor->address }}</td>
                                <td>{{ $doctor->status }}</td>
                                <td>
                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    {{ $doctors->links() }}
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to Departments</a>
        </div>
    </div>
@endsection
