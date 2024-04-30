<x-admin.nav>
    <div class="container pt-2">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('cash.create') }}" class="btn btn-block btn-primary ">Cash Withraw/Deposite from
                    Bank</a>
            </div>
            @if (count($cash))
                <div class="col-6">
                    <a href="{{ route('cash.edit', $cash[count($cash) - 1]->id) }}"
                        class="btn btn-block btn-warning ">Adjust Cash Balance</a>
                </div>
            @endif
        </div>
        <div class="pt-2">
            <table id="example" class="display" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Payment ID </th>
                        <th>Expense ID </th>
                        <th>Amount </th>
                        <th>Balance </th>
                        <th>Category </th>
                        <th>Date </th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cash))
                        @foreach ($cash as $c)
                            <tr>
                                <td> {{ $c->id }}</td>
                                <td> {{ $c->payment_id }} </td>
                                <td> {{ $c->expense_id }} </td>
                                <td> {{ number_format($c->amount, 2) }} </td>
                                <td> {{ number_format($c->balance, 2) }} </td>
                                <td> {{ $c->category }} </td>
                                <td> {{ Carbon\Carbon::parse($c->created_at)->format('Y-m-d') }} </td>
                                <td>
                                    <a class="btn btn-primary"  href="{{ route('cash.edit', $c->id) }}" class="far fa-edit">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr> No Data Found </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <script>
        new DataTable('#example', {
            info: false,
            lengthChange: false,
            pageLength: 20,
            order: [0, 'desc'],
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>

</x-admin.nav>
