{{-- Flash Messages --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Rental Request Form --}}
<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Send Rental Request</h5>
        <form action="{{ route('student.rentals.request', $rental->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Message to Landlord (optional)</label>
                <textarea
                    name="message"
                    id="message"
                    rows="3"
                    placeholder="Write a message to the landlord..."
                    class="form-control"
                ></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-fill me-1"></i> Request Rental
                </button>
            </div>
        </form>
    </div>
</div>
