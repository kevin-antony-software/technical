<x-admin.nav>
    <div class="container pt-2">
        {{-- <a class="btn btn-primary" href="{{ route('courier_weight_charge.create') }}" role="button">Create New Courier Charge</a> --}}
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Weight</th>
                    <th>Courier Charge</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courier_weight_charges as $courier_weight_charge)
                    <tr>
                        <td>{{ $courier_weight_charge->id }}</td>
                        <td>{{ $courier_weight_charge->weight }}</td>
                        <td>{{ $courier_weight_charge->courier_charges }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('courier_weight_charge.edit', $courier_weight_charge->id) }}"
                                role="button">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('courier_weight_charge.destroy', $courier_weight_charge->id) }}" method="post"
                                onclick="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
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
            order: [1, 'asc'],
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
</x-admin.nav>
