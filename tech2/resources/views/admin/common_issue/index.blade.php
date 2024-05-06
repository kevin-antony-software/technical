<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('common_issue.create') }}" role="button">Create New common issue</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Issue</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($common_issues as $common_issue)
                    <tr>
                        <td>{{ $common_issue->id }}</td>
                        <td>{{ $common_issue->issue }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('common_issue.edit', $common_issue) }}"
                                role="button">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('common_issue.destroy', $common_issue) }}" method="post"
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
