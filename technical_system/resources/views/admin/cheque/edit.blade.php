<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('cheque.update', $cheque->id) }}">
            @csrf @method('PUT')
            <table class="table table-bordered">
                <tr>
                    <th width=40%>Item</th>
                    <th width=35%>Old</th>
                    <th width=25%>New</th>
                </tr>
                <tr>
                    <td>Cheque No</td>
                    <td>{{ $cheque->cheque_number }}</td>
                    <td><input type="number" name="NewChequeNo" id="NewChequeNo" class="form-control"
                            value="{{ $cheque->cheque_number }}"></td>
                </tr>
                <tr>
                    <td>Branch</td>
                    <td>{{ $cheque->cheque_branch }}</td>
                    <td><input type="number" name="NewBranchNo" id="NewBranchNo" class="form-control"
                            value="{{ $cheque->cheque_branch }}"></td>
                </tr>
                <tr>
                    <td>Bank</td>
                    <td>{{ $cheque->cheque_bank }}</td>
                    <td><input type="number" name="NewBankNo" id="NewBankNo" class="form-control"
                            value="{{ $cheque->cheque_bank }}"></td>
                </tr>
                <tr>
                    <td>Cheque Date</td>
                    <td>{{ $cheque->cheque_date }}</td>
                    <td><input type="date" name="newChequeDate" id="newChequeDate" class="form-control"
                            value="{{ $cheque->cheque_date }}"></td>
                </tr>
            </table>

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('cheque.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Update cheque</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
