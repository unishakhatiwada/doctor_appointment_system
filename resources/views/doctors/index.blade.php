
@extends('admin.layouts.app')

@push('css')
    @vite('resources/css/app.css')
    @vite('resources/sass/style.scss')
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Doctors</div>
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
