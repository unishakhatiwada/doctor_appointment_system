@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Doctor Details</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $doctor->name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Address:</strong> {{ $doctor->address }}</p>
                <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                <p><strong>Status:</strong> {{ ucfirst($doctor->status) }}</p>
                <p><strong>Department:</strong> {{ $doctor->department->name }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('doctors.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection

