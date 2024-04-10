<x-admin.nav>
    <div class="container pt-2">
        <h3>Create component Form</h3>
        <form method="POST" action="{{ route('component.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" class="form-control" id="cost" name="cost" value="{{ old('cost') }}">
                @error('cost')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>`
            <div class="mb-3">
                <label for="component_category_id" class="form-label">component category</label>
                <select name="component_category_id" id="component_category_id" class="form-control">
                    @foreach ($component_categories as $component_category)
                    <option value="{{ $component_category->id }}">{{ $component_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('component.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Save New component</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
