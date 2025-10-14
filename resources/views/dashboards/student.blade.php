@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-4">Student Dashboard</h1>
        <p class="text-gray-600">Welcome, {{ auth()->user()->name }}! Browse available rental listings and manage your applications.</p>
    </div>
@endsection
