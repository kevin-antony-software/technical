<x-admin.nav>
    <div class="container pt-2">
        <h3>Create Machine Model Form</h3>
        <form method="POST" action="{{ route('machine_model.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">weight</label>
                <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('machine_model.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Save New machine model</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
