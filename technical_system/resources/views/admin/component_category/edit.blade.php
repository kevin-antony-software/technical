<x-admin.nav>
    <div class="container pt-2">
        <h3>Edit Component Category Form</h3>
        <form method="POST" action="{{ route('component_category.update', $component_category) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $component_category->name }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('component_category.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update component category</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
