<x-admin.nav>
    <div class="container pt-2">
        <form method="POST" action="{{ route('component_stock.update', $component_stock) }}">
            @csrf
            @method('PUT')
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Component</th>
                        <th>Old Qty</th>
                        <th>New Qty</th>
                        <th>Submit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $component_stock->id }}</td>
                        <td>{{ $component_stock->component->name }}</td>
                        <td>{{ $component_stock->qty }}</td>
                        <td>
                            <input type="number" name="new_qty" id="new_qty" class="form-control">
                        </td>
                        <td> <button type="submit" class="btn btn-block btn-primary">Change Qty</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        new DataTable('#example', {
            info: false,
            lengthChange: false,
            searching: false,
            paging: false,
        });
    </script>
</x-admin.nav>
