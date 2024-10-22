
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Add Doctors to Department: {{ $department->name }}</h1>

        <form action="{{ route('departments.addDoctors', $department->id) }}" method="POST">
            @csrf

            <!-- Multi-Select for Doctors -->
            <div class="form-group">
                <label for="doctor_ids">Select Doctors</label>
                <select name="doctor_ids[]" class="form-control" id="doctor_ids" multiple>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Add Doctors</button>
            <a href="{{ route('departments.show', $department->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
