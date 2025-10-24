@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold mb-4">Create New Rental Listing</h4>

                {{-- Flash messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some issues with your input.<br><br>
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
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price (USD)</label>
                            <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="images" class="form-label fw-semibold">Upload Images</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple>
                            <small class="text-muted">You can upload multiple images (jpg, png, gif, max 2MB each)</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Create Listing
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
