@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Create Department</h1>
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <!-- Department Input Fields -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" class="form-control" id="code" value="{{ old('code') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Department</button>
        </form>
    </div>
@endsection
