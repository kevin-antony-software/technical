<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('component.create') }}" role="button">Create New component</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Action</th>
                    <th>Cost</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($components as $component)
                    <tr>
                        <td>{{ $component->id }}</td>
                        <td>{{ $component->name }}</td>
                        <td>{{ $component->component_category->name }}</td>
                        <td class="">
                            <div class="row">
                                <div class="col-5">
                                        <a class="btn btn-primary btn-sm" href="{{ route('component.edit', $component) }}"
                                            role="button">Edit</a>
                                </div>
                                <div class="col-5">
                                        <form action="{{ route('component.destroy', $component) }}" method="post" onclick="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $component->cost }}</td>
                        <td>{{ $component->price }}</td>

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
