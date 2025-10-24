{{-- Flash messages --}}
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-3">
        {{ session('error') }}
    </div>
@endif

{{-- Rental Request Form --}}
<form action="{{ route('student.rentals.request', $rental->id) }}" method="POST" class="mt-4">
    @csrf
    <textarea
        name="message"
        rows="3"
        placeholder="Write a message to the landlord (optional)..."
        class="w-full border border-gray-300 rounded-lg p-2 mb-3 focus:ring-2 focus:ring-blue-400"
    ></textarea>

    <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
        Request Rental
    </button>
</form>
