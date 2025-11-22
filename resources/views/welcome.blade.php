<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=60') center/cover no-repeat;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 0 3px 8px rgba(0,0,0,0.7);
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .listing-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- ========================== NAVBAR ========================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Student Rentals</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'landlord')
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('landlord.dashboard') }}">Landlord Dashboard</a>
                            </li>
                    @endif
                    @if(auth()->user()->role === 'student')
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('student.dashboard') }}">Student Dashboard</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<!-- ========================== HERO ========================== -->
<div class="hero text-center">
    <div>
        <h1>Find Your Next Student Home</h1>
        <p class="lead">Affordable housing for students — verified landlords, simple process.</p>
        <a href="{{ route('student.rentals.index') }}" class="btn btn-lg btn-primary mt-3">
            Browse Rentals
        </a>
    </div>
</div>

<!-- ========================== FEATURED LISTINGS (optional) ========================== -->
<div class="container my-5">
    <h2 class="mb-4">Latest Listings</h2>

    @if(!empty($rentals) && count($rentals) > 0)
        <div class="row">
            @foreach($rentals as $rental)
                <div class="col-md-4 mb-4">
                    <div class="card listing-card shadow-sm">
                        <img src="{{ $rental->images->first()->image_path ?? 'https://via.placeholder.com/400x200?text=No+Image' }}"
                             class="card-img-top" alt="rental image">

                        <div class="card-body">
                            <h5 class="card-title">{{ $rental->title }}</h5>
                            <p class="text-muted">{{ $rental->location }}</p>
                            <p class="fw-bold">${{ $rental->price }} / month</p>
                            <a href="{{ route('student.rentals.show', $rental->id) }}" class="btn btn-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No rentals available right now.</p>
    @endif
</div>

<footer class="text-center py-4 text-muted small">
    &copy; {{ date('Y') }} Student Rentals Platform
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
