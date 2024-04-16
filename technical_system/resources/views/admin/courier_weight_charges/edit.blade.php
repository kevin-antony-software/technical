<x-admin.nav>
    <div class="container pt-2">

        <h3>Edit courier weight charge Form</h3>
        <form method="POST" action="{{ route('courier_weight_charge.update', $courier_weight_charge->id ) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" value="{{ $courier_weight_charge->weight }}" readonly>
                @error('weight')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="courier_charges" class="form-label">courier charges</label>
                <input type="number" class="form-control" id="courier_charges" name="courier_charges" value="{{ $courier_weight_charge->courier_charges }}">
                @error('courier_charges')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('courier_weight_charge.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update component</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
