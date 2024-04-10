<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-secondary" href="{{ route('customer.index') }}" role="button">Go Back to Index</a>
        <form method="POST" action="{{ route('customer.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="number" class="form-control" id="mobile" name="mobile">
            </div>
            <div class="mb-3">
                <label for="land_phone" class="form-label">Land Phone Number</label>
                <input type="number" class="form-control" id="land_phone" name="land_phone">
            </div>
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" class="form-control" id="company" name="company">
            </div>
            <button type="submit" class="btn btn-primary">Save New Customer</button>
        </form>
    </div>
</x-admin.nav>
