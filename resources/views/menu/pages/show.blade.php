@extends('layouts.app')
@section('background_image', asset('images/doctor-background.jpg'))
@section('content')
    <!-- Include the booking steps partial -->
    @include('partials._booking_steps')
    <!-- Success Toast Notification -->
    @if(session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; right: 20px; top: 20px;">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <p>{{ $page->content }}</p>
    </div>
@endsection
