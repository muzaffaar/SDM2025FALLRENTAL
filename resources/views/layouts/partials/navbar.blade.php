<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="/" class="font-bold text-lg text-blue-600">🏠 Rental Portal</a>

        <div class="space-x-4">
            @auth
                @php($role = auth()->user()->role)

                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        Admin Dashboard
                    </a>
                @elseif($role === 'landlord')
                    <a href="{{ route('landlord.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        Landlord Dashboard
                    </a>
                @elseif($role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        Student Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-600 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
            @endauth
        </div>
    </div>
</nav>
