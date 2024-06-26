<x-admin.nav>
    <div class="container">
        <form method="POST" id = "formID" action="{{ route('cash.store') }}" onsubmit="return validateForm()">
            @csrf
            <div class="pt-3 mb-3 row">
                <label class="col-sm-2 col-form-label" for="BankAction">Action</label>
                <div class="col-sm-10">
                    <select name="BankAction" id="BankAction" class="form-control">
                        <option value="deposite">Deposite</option>
                        <option value="Withdraw">Withdraw</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="Bank">Select Bank</label>
                <div class="col-sm-10">
                    <select name="Bank" id="Bank" class="form-control">
                        <option value="">Select Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="Available"> Available</label>
                <div class="col-sm-10">
                    <input class="form-control" type="number" name="Available" id="Available"
                        value="{{ $cashBalance }}" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="Amount">Amount</label>
                <div class="col-sm-10">
                    <input class="form-control" type="number" name="Amount" id="Amount">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('cash.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Deposite / Withdraw from Bank</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            if (document.getElementById("Bank").value == "") {
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
        document.getElementById("BankAction").addEventListener("change", balanceUpdate);
        document.getElementById("Bank").addEventListener("change", bankBalance);

        function balanceUpdate() {
            var bankBalance;
            var bankID = document.getElementById("Bank").value;
            @foreach ($banks as $b)
                if ({{ $b->id }} == bankID) {
                    bankBalance = {{ $b->balance }};
                }
            @endforeach
            if (document.getElementById("BankAction").value == 'deposite') {
                document.getElementById("Available").value = {{ $cashBalance }};
            } else if (document.getElementById("BankAction").value == 'Withdraw') {
                document.getElementById("Available").value = bankBalance;
            }
        }

        function bankBalance() {
            var bankBalance;
            var bankID = document.getElementById("Bank").value;
            @foreach ($banks as $b)
                if ({{ $b->id }} == bankID) {
                    bankBalance = {{ $b->balance }};
                }
            @endforeach
            if (document.getElementById("BankAction").value != 'deposite') {
                document.getElementById("Available").value = bankBalance;
            } else if (document.getElementById("BankAction").value != 'Withdraw') {
                document.getElementById("Available").value = {{ $cashBalance }};
            }
        }
    </script>

</x-admin.nav>
