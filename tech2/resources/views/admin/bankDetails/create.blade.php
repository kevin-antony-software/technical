<x-admin.nav>
    <div class="container pt-2">
        <form method="POST" action="{{ route('bank_detail.store') }}" onsubmit="return validateForm()">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="FromBankname">From Bank</label>
                <div class="col-sm-10">
                    <select name="FromBankname" id="FromBankname" class="form-control">
                        <option value="">From Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="Available"> Available</label>
                <div class="col-sm-10">
                    <input class="form-control" type="number" name="Available" id="Available" value="" disabled>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="ToBankname">To Bank</label>
                <div class="col-sm-10">
                    <select name="ToBankname" id="ToBankname" class="form-control">
                        <option value="">To Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="Amount">Amount</label>
                <div class="col-sm-10">
                    <input class="form-control" step='0.01' type="number" name="Amount" id="Amount">
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('bank.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Transfer</button>
                </div>
            </div>

        </form>
    </div>
    <script>
        function validateForm() {
            if (document.getElementById("FromBankname").value == "") {
                alert("Bank needs to be selected");
                return false;
            }
            if (document.getElementById("ToBankname").value == "") {
                alert("Bank needs to be selected");
                return false;
            }
            if (document.getElementById("Amount").value == "") {
                alert("Amount cant be empty");
                return false;
            }

            if (parseInt(document.getElementById("Available").value) < parseInt(document.getElementById("Amount").value)) {
                alert("Available cant be less than Amount");
                return false;
            }
        }
    </script>

    <script>
        document.getElementById("FromBankname").addEventListener("change", bankBalance);

        function bankBalance() {
            var bankBalance;
            var bankID = document.getElementById("FromBankname").value;

            @foreach ($banks as $b)
                if ({{ $b->id }} == bankID){
                bankBalance = {{ $b->balance }};
                }
            @endforeach

            document.getElementById("Available").value = bankBalance;
        }
    </script>
</x-admin.nav>
