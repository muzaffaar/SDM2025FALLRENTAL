@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 fw-bold mb-4">Edit Rental Listing</h2>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('landlord.rentals.update', $rental->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Title --}}
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input type="text" id="title" name="title"
                                   value="{{ old('title', $rental->title) }}"
                                   class="form-control @error('title') is-invalid @enderror" required>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price (USD)</label>
                            <input type="number" id="price" name="price" step="0.01" min="0"
                                   value="{{ old('price', $rental->price) }}"
                                   class="form-control @error('price') is-invalid @enderror" required>
                        </div>

                        {{-- Location --}}
                        <div class="col-md-12">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input type="text" id="location" name="location"
                                   value="{{ old('location', $rental->location) }}"
                                   class="form-control @error('location') is-invalid @enderror" required>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $rental->description) }}</textarea>
                        </div>

                        {{-- Current Image Preview --}}
                        @if ($rental->image_path)
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Current Image</label><br>
                                <img src="{{ asset('storage/' . $rental->image_path) }}" alt="Current Rental Image"
                                     class="rounded mb-2" style="width: 200px; height: 150px; object-fit: cover;">
                            </div>
                        @endif

                        {{-- New Image Upload --}}
                        <div class="col-md-12">
                            <label for="image" class="form-label fw-semibold">Upload New Image (optional)</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <div class="form-text">Allowed formats: JPG, JPEG, PNG, GIF (max 2MB)</div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('landlord.rentals.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-1"></i> Update Rental
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
