<x-admin.nav>
<div class="container">
        <form method="POST" action="{{ route('expense.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="to">To</label>
                <input type="text" class="form-control" id="to" name="to" aria-describedby="to"
                    value="{{ old('to') }}" required>
                @error('to')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="method">Method</label>
                <SELECT name="method" id="method" class="form-control">
                    <option value="cash">Cash</option>
                    @can('managers-only')
                        <option value="Bank Transfer">Bank Transfer</option>
                    @endcan
                </SELECT>
            </div>
            @can('managers-only')
                <div class="form-group" id="bankA" hidden>
                    <label for="bank">Bank</label>
                    <SELECT name="bank" id="bank" class="form-control">
                        <option value="">Choose bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </SELECT>
                </div>
            @endcan


            <div class="form-group">
                <label for="amount">Amount </label>
                <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount"
                    value="{{ old('amount') }}">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="reason">Reason</label>
                <input type="text" class="form-control" id="reason" name="reason"
                    aria-describedby="reason" value="{{ old('reason') }}" required>
                @error('reason')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image1">Upload Image of Receipt</label>
                <div class="col-md-12">
                    <input type="file" name="image1" id = "image1" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('expense.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Save New component</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        document.getElementById("method").addEventListener("change", myFunctionL);

        function myFunctionL() {

            if (document.getElementById("method").value == "Bank Transfer") {
                document.getElementById("bankA").hidden = false;

            } else {
                document.getElementById("bankA").hidden = true;
            }

        }
    </script>
</x-admin.nav>
