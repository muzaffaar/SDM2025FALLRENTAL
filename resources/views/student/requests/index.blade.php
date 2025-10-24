@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6">My Rental Requests</h2>

        @if ($requests->count())
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Rental Title</th>
                        <th class="px-4 py-3 text-left">Landlord</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Message</th>
                        <th class="px-4 py-3 text-left">Requested At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($requests as $request)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">
                                {{ $request->rental->title ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $request->rental->landlord->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $color = match($request->status) {
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $request->message ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $request->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">You haven't submitted any rental requests yet.</p>
        @endif
    </div>
@endsection
