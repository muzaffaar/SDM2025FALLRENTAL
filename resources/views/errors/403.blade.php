@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">403 – Forbidden</h1>
        <p>You don’t have permission to access this page.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Return Home</a>
    </div>
@endsection
