<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('component_category.create') }}" role="button">Create New component category</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component_categories as $component_category)
                    <tr>
                        <td>{{ $component_category->id }}</td>
                        <td>{{ $component_category->name }}</td>
                        <td>
                            <div class="row">
                                <div class="col-5">
                                        <a class="btn btn-primary btn-sm" href="{{ route('component_category.edit', $component_category) }}"
                                            role="button">Edit</a>
                                </div>
                                <div class="col-5">
                                        <form action="{{ route('component_category.destroy', $component_category) }}" method="post" onclick="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                </div>
                            </div>
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
