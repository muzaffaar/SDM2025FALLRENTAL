@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">404 – Page Not Found</h1>
        <p>The page you’re looking for doesn’t exist.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Back</a>
    </div>
@endsection
