<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('bank.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="balance">Account balance</label>
                <input type="number" class="form-control" id="balance" name="balance" aria-describedby="balance"
                    value="{{ old('balance') }}">
                @error('balance')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('bank.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Save New Bank</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
