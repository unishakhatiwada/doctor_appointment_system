@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Welcome, {{ Auth::guard('admin')->user()->name }}</h1>
        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
