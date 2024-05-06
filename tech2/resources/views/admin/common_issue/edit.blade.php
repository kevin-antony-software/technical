<x-admin.nav>
    <div class="container pt-2">
        <h3>Edit common issue Form</h3>
        <form method="POST" action="{{ route('common_issue.update', $common_issue) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="issue" class="form-label">Common Issue</label>
                <textarea class="form-control" id="issue" name="issue" rows="3">{{ $common_issue->issue }}</textarea>
                @error('issue')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('common_issue.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update common issue</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
