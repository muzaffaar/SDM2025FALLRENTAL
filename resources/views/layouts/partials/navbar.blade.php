@php
    $is = fn($pattern) => request()->routeIs($pattern) ? 'active fw-semibold text-primary' : '';
    $brandHref = '/';
    if(auth()->check()){
        $r = auth()->user()->role;
        $brandHref = $r === 'admin' ? route('admin.dashboard')
                   : ($r === 'landlord' ? route('landlord.dashboard')
                   : ($r === 'student' ? route('student.dashboard') : '/'));
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand fw-bold text-primary" href="{{ $brandHref }}">
            🏠 Rental Portal
        </a>

        {{-- Mobile Toggler --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0">

                @auth
                    @php($role = auth()->user()->role)

                    {{-- ADMIN --}}
                    @if($role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $is('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ $is('admin.users.*') }}">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rentals.index') }}" class="nav-link {{ $is('admin.rentals.*') }}">
                                Rentals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.requests.index') }}" class="nav-link {{ $is('admin.requests.*') }}">
                                Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.activities.index') }}" class="nav-link {{ $is('admin.activities.*') }}">
                                Activities
                            </a>
                        </li>
                    @endif

                    {{-- LANDLORD --}}
                    @if($role === 'landlord')
                        <li class="nav-item">
                            <a href="{{ route('landlord.dashboard') }}" class="nav-link {{ $is('landlord.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('landlord.rentals.index') }}" class="nav-link {{ $is('landlord.rentals.*') }}">
                                My Rentals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('landlord.requests.index') }}" class="nav-link {{ $is('landlord.requests.*') }}">
                                Requests
                            </a>
                        </li>
                    @endif

                    {{-- STUDENT --}}
                    @if($role === 'student')
                        <li class="nav-item">
                            <a href="{{ route('student.dashboard') }}" class="nav-link {{ $is('student.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.rentals.index') }}" class="nav-link {{ $is('student.rentals.*') }}">
                                Browse Rentals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.requests.index') }}" class="nav-link {{ $is('student.requests.*') }}">
                                My Requests
                            </a>
                        </li>
                    @endif

                    {{-- Divider --}}
                    <li class="nav-item mx-2 text-muted">|</li>

                    {{-- Logout --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-danger p-0">
                                Logout
                            </button>
                        </form>
                    </li>

                @else
                    {{-- Guest links --}}
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link {{ $is('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link {{ $is('register') }}">
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
