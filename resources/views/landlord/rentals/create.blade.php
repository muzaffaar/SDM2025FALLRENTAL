@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 fw-bold mb-4">Create New Rental Listing</h2>

                {{-- Flash message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('landlord.rentals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price (USD)</label>
                            <input type="number" id="price" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   step="0.01" min="0" value="{{ old('price') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input type="text" id="location" name="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label fw-semibold">Upload Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <div class="form-text">Allowed: jpg, jpeg, png, gif. Max size 2MB.</div>
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Create Rental
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
