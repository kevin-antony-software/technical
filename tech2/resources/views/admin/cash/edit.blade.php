<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('cash.update', $cash->id) }}" onsubmit="return validateForm()">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="currentCash">Old Cash Balance in the System</label>
                <input type="number" class="form-control" id="currentCash" name="currentCash"
                    value="{{ $cash->balance }}" disabled>
            </div>

            <div class="form-group">
                <label for="newCash">new Correct Cash Amount</label>
                <input type="number" class="form-control" id="newCash" name="newCash" value="">
            </div>
            @error('newCash')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('cash.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update Cash</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function validateForm() {
            if (document.getElementById("newCash").value == "") {
                alert("New Cash cant be blank");
                return false;
            }
        }
    </script>
</x-admin.nav>
