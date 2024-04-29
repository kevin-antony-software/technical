<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('register') }}" role="button">Create New User</a>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Edit User</th>
                    <th>Change Password</th>
                    <th>Delete User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->position }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('user.edit', $user) }}"
                                role="button">Edit</a>
                        </td>
                        <td>
                            <a href="{{ route('user.changePassword', $user->id) }}" class="btn btn-primary btn-sm" role="button"
                                style="margin-right: 10px;">Password</a>
                        </td>
                        <td>
                            <form action="{{ route('user.destroy', $user) }}" method="post"
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
