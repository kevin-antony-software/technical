<x-admin.nav>
    <div class="container">
        <a href="{{ route('payment.index') }}" class="btn btn-primary float-right" style="margin-top: 5px;">Back to Index
        </a>
    </div>

    <div class="container">
        <table class="table table-hover table-bordered" style="margin-top: 5px;">
            <thead class="thead-dark">
                <tr style="text-align: center;">
                    <th width=50%>item</th>
                    <th width=50%>value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $payment->customer->name }}</td>
                </tr>
                <tr>
                    <th>User Name</th>
                    <td>{{ $payment->user->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $payment->status }}</td>
                </tr>
                <tr>
                    <th>Method</th>
                    <td>{{ $payment->method }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>{{ $payment->amount }}</td>
                </tr>
                <tr>
                    <th>Allocated to Invoice</th>
                    <td>{{ $payment->allocated_to_job }}</td>
                </tr>
                <tr>
                    <th>Balance to Allocate</th>
                    <td>{{ $payment->balance_to_allocate }}</td>
                </tr>
                @if ($payment->method == 'BankTransfer')
                    <tr>
                        <th>Bank Transfer</th>
                        <td>{{ $payment->bank->name }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if (count($payment_links))
            <table class="table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Job ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment_links as $link)
                        <tr>
                            <th>{{ $link->payment_id }}</th>
                            <th>{{ $link->repair_job_id }}</th>
                            <td>{{ $link->amount }}</td>
                            <td>{{ Carbon\Carbon::parse($link->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            No Invoice Linked Yet
        @endif

        @if ($payment->method == 'Cheque')
            <h1 style="text-align: center;">Cheque Details</h1>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Cheque No</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cheques as $c)
                        <tr>
                            <th>{{ $c->id }}</th>
                            <th>{{ $c->cheque_bank }}</th>
                            <td>{{ $c->cheque_branch }}</td>
                            <td>{{ $c->cheque_number }}</td>
                            <td>{{ $c->amount }}</td>
                            <td>{{ $c->status }}</td>
                            <td>{{ Carbon\Carbon::parse($c->cheque_date)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif


    </div>
</x-admin.nav>
