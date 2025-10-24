@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold mb-4">Available Rentals</h2>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6 bg-gray-100 p-4 rounded-lg">
            <input type="text" name="location" placeholder="Location"
                   value="{{ request('location') }}"
                   class="border border-gray-300 p-2 rounded-md flex-1">

            <input type="number" name="min_price" placeholder="Min Price"
                   value="{{ request('min_price') }}"
                   class="border border-gray-300 p-2 rounded-md w-32">

            <input type="number" name="max_price" placeholder="Max Price"
                   value="{{ request('max_price') }}"
                   class="border border-gray-300 p-2 rounded-md w-32">

            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Filter</button>
        </form>

        {{-- Rentals Grid --}}
        @if($rentals->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($rentals as $rental)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ asset($rental->image_path ?? 'images/default.jpg') }}" alt="rental" class="h-48 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-1">{{ $rental->title }}</h3>
                            <p class="text-gray-600 mb-1">{{ $rental->location }}</p>
                            <p class="text-blue-600 font-bold mb-2">${{ number_format($rental->price, 2) }}</p>
                            <p class="text-sm text-gray-700">{{ Str::limit($rental->description, 80) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $rentals->links() }}
            </div>
        @else
            <p class="text-gray-600">No rentals found.</p>
        @endif

    </div>
@endsection
