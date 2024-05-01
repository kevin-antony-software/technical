<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('payment.create') }}" role="button">Create New Payment</a>
        <div class="pt-2">
            <table id="example" class="display" width="100%">

                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer Name </th>
                        <th>User </th>
                        <th>Method </th>
                        <th>Amount </th>
                        <th>Allocated </th>
                        <th>Balance </th>
                        <th>Status </th>
                        <th>Action </th>
                        <th>Receive</th>
                        <th width=20%>Link Invoice</th>

                    </tr>
                </thead>
                <tbody>
                    @if (count($payments))
                        @foreach ($payments as $payment)
                            <tr>
                                <td> {{ $payment->id }}</td>
                                <td> {{ $payment->customer->name }}</td>
                                <td> {{ $payment->user->name }}</td>
                                <td> {{ $payment->method }} </td>
                                <td> {{ $payment->amount }} </td>
                                <td> {{ $payment->allocated_to_job }} </td>
                                <td> {{ $payment->balance_to_allocate }} </td>
                                <td> {{ $payment->status }} </td>
                                <td>
                                    <a href="{{ route('payment.show', $payment->id) }}" class="fas fa-eye"></a>
                                    <a href="{{ route('payment.print', $payment->id) }}" class="fas fa-print"></a>
                                    @can('director-only')
                                        @if ($payment->status == 'with sales')
                                            <a href="{{ route('payment.edit', $payment->id) }}" class="far fa-edit"></a>
                                        @endif
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"
                                            class="far fa-trash-alt"></a>
                                        <form action="{{ route('payment.destroy', $payment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan

                                </td>
                                <td>
                                    @if ($payment->status == 'with sales')
                                        @can('director-only')
                                            <a href="javascript:void(0)"
                                                onclick="$(this).parent().find('form').submit()">Receive</a>
                                            <form action="{{ route('payment.payment_receive', $payment->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                                <td>
                                    @if ($payment->balance_to_allocate > 0)

                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('LinkJob.link', $payment->id) }}" role="button">Link
                                            Repair Job</a>
                                    @else
                                        nothing to link
                                    @endif
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
    <div class="float-right">
        {{ $payments->links() }}
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
