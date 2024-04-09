<x-admin.nav>
    @isset($message)
    <x-admin.alert>
            {{ $message }}
    </x-admin.alert>
    @endisset
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('customer.create')}}" role="button">Create New Customer</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
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
            pageLength: 100
        });
    </script>
</x-admin.nav>
