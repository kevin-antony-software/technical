<x-admin.nav>


    <div class="container pt-2">

        <table id="example" class="display">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>User Name</th>
                    <th>Jobs Closed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->year }}</td>
                        <td>{{ $item->month }}</td>
                        <td>{{ $item->user_name }}</td>
                        <td>{{ $item->count_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        new DataTable('#example', {
            info: false,
            lengthChange: false,
            pageLength: 50,
            order: [[0, 'desc'], [1, 'desc']],
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>

</x-admin.nav>
