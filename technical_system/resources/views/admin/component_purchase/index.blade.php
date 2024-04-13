<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('component_purchase.create') }}" role="button">Create New component
            purchase</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component_purchases as $component_purchase)
                    <tr>
                        <td>{{ $component_purchase->id }}</td>
                        <td>{{ $component_purchase->status }}</td>
                        <td>{{ $component_purchase->user->name }}</td>
                        <td>{{ $component_purchase->created_at }}</td>
                        <td>
                            @if ($component_purchase->status == 'Pending')
                                <a class="btn btn-primary btn-sm" href="{{ route('component_purchase.edit', $component_purchase) }}"
                                    role="button">Approve</a>
                            @else
                            {{$component_purchase->status}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
