<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('component_purchase.index') }}" role="button">Back to index</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component_pruchase_details as $component_pruchase_detail)
                    <tr>
                        <td>{{ $component_pruchase_detail->component->id }}</td>
                        <td>{{ $component_pruchase_detail->component->name }}</td>
                        <td>{{ $component_pruchase_detail->qty }}</td>
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
