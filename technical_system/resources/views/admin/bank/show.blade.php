<x-admin.nav>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <div class="container">

        <div class="container pt-2">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('bank.index') }}" class="btn btn-block btn-primary"><strong> Back to Index </strong></a>
                </div>

            </div>
        </div>
    </div>
    <section class="content">
        <div class="container pt-2">


            <div class="pt-2">
                <table id="example" class="display" width="100%">

                    <thead class="thead-dark">
                        <tr>
                            <th style="width:10%;">ID</th>
                            <th style="width:10%;">Bank ID </th>
                            <th style="width:10%;">Payment ID </th>
                            <th style="width:10%;">Expense ID </th>
                            <th style="width:10%;">Reason </th>
                            <th style="width:10%;">Credit </th>
                            <th style="width:10%;">Debit </th>
                            <th style="width:10%;">balance </th>
                            <th style="width:10%;">Date </th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (count($bankDetails))
                            @foreach ($bankDetails as $item)
                                <tr>
                                    <td> {{ $item->id }}</td>
                                    <td> {{ $item->bank->name }} </td>
                                    <td> {{ $item->payment_id }} </td>
                                    <td> {{ $item->expense_id }} </td>
                                    <td> {{ $item->reason }} </td>
                                    <td> {{ $item->credit_amount }} </td>
                                    <td> {{ $item->debit_amount }} </td>
                                    <td> {{ number_format($item->bank_balance,2) }} </td>
                                    <td> {{ $item->created_at }} </td>


                                </tr>
                            @endforeach
                        @else
                            <tr> No Data Found </tr>
                        @endif
                    </tbody>
                </table>
                {{ $bankDetails->links() }}
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
    </section>
</x-admin.nav>
