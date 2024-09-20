
@extends('admin.layouts.app')

@push('css')
    @vite('resources/css/app.css')
    @vite('resources/sass/style.scss')
@endpush

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">Doctors</a></li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header h2 text-purple">Manage Doctors</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/app.js')
    {{ $dataTable->scripts() }}
@endpush
