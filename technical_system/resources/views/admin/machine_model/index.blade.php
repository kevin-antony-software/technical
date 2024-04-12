<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('machine_model.create') }}" role="button">Create New Machine Model
            category</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Weight</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($machine_models as $machine_model)
                    <tr>
                        <td>{{ $machine_model->id }}</td>
                        <td>{{ $machine_model->name }}</td>
                        <td>{{ $machine_model->weight }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                                href="{{ route('machine_model.edit', $machine_model) }}" role="button">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('machine_model.destroy', $machine_model) }}" method="post"
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
