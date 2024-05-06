<x-admin.nav>
    <div class="container pt-2">

        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>job id</th>
                    <th>status</th>
                    <th>user</th>
                    <th>month</th>
                    <th>year</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data1 as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->repair_job_id }}</td>
                        <td>{{ $item->status->status }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at->month }}</td>
                        <td>{{ $item->created_at->year }}</td>
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
