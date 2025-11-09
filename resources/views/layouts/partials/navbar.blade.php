<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand fw-bold text-primary" href="/">
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

                    {{-- Role-specific dashboards --}}
                    @if($role === 'admin')
                        {{-- Admin Navigation --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rentals.index') }}" class="nav-link">
                                Rentals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.activities.index') }}" class="nav-link">
                                Activities
                            </a>
                        </li>

                    @elseif($role === 'landlord')
                        {{-- Landlord Navigation --}}
                        <li class="nav-item">
                            <a href="{{ route('landlord.dashboard') }}" class="nav-link">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('landlord.rentals.index') }}" class="nav-link">
                                My Rentals
                            </a>
                        </li>

                    @elseif($role === 'student')
                        {{-- Student Navigation --}}
                        <li class="nav-item">
                            <a href="{{ route('student.dashboard') }}" class="nav-link">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.rentals.index') }}" class="nav-link">
                                Browse Rentals
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
                        <a href="{{ route('login') }}" class="nav-link">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
