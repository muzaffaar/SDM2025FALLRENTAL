@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">500 – Server Error</h1>
        <p>Something went wrong on our side. We’re already looking into it.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Try Again Later</a>
    </div>
@endsection
