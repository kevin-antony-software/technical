<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('bank.update', $bank->id) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="name">Bank Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name"
                    value="{{ $bank->name }}" required>
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror


            <div class="form-group">
                <label for="balance">Balance</label>
                <input type="number" step = "0.01" class="form-control" id="balance" name="balance"
                    aria-describedby="balance" value="{{ $bank->balance }}">
            </div>
            @error('balance')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('bank.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update Bank</button>
                </div>
            </div>
        </form>
    </div>

</x-admin.nav>
