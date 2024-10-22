
@extends('admin.layouts.app')

@push('css')
    @vite('resources/css/app.css')
    @vite('resources/sass/style.scss')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Title on the left -->
            <div class="h2 text-purple">Manage Departments</div>

            <!-- Breadcrumb on the right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                </ol>
            </nav>
        </div>
        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/app.js')
    {{ $dataTable->scripts() }}
@endpush
