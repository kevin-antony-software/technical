<x-admin.nav>
    <div class="container pt-2">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('expense.create') }}" class="btn btn-primary ">Add new Expense</a>
            </div>
        </div>
        <div class="pt-2">
            <table id="example" class="display" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>User</th>
                        <th>Reason</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($expenses))
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{!! $expense->id !!}</td>
                                <td>{!! $expense->to !!}</td>
                                <td>{!! $expense->amount !!}</td>
                                <td>{!! $expense->user->name !!}</td>
                                <td>{!! $expense->reason !!}</td>
                                <td> <a href="{{ route('expense.show', $expense->id) }}"
                                        class="btn btn-primary">view</a></td>
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
