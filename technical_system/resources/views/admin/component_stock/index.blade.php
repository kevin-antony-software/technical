<x-admin.nav>
    <div class="container pt-2">
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Component</th>
                    <th>qty</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component_stocks as $component_stock)
                    <tr>
                        <td>{{ $component_stock->id }}</td>
                        <td>{{ $component_stock->component->name }}</td>
                        <td>{{ $component_stock->qty }}</td>
                        <td>

                            <a class="btn btn-primary btn-sm"
                                href="{{ route('component_stock.edit', $component_stock) }}" role="button">Edit</a>
                        </td>
                        <td>

                            <form action="{{ route('component_stock.destroy', $component_stock) }}" method="post"
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
            order: [0, 'desc'],
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
</x-admin.nav>
