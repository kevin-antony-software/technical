<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('customer.create') }}" role="button">Create New Customer</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Land Phone</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td class="">

                                        <a class="btn btn-primary btn-sm" href="{{ route('customer.edit', $customer) }}"
                                            role="button">Edit</a>
                        </td>
                        <td>

                                        <form action="{{ route('customer.destroy', $customer) }}" method="post" onclick="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>

                        </td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->mobile }}</td>
                        <td>{{ $customer->land_phone }}</td>
                        <td>{{ $customer->company }}</td>
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
