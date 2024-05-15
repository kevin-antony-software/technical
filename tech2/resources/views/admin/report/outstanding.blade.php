<x-admin.nav>
    <div class="container pt-2">
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Customer</th>
                    <th>Machine Model</th>
                    <th>Due Amount </th>
                    <th>Job Created Date </th>
                    <th>Days </th>
                </tr>
            </thead>
            <tbody>

                @if (count($repair_jobs))
                    @foreach ($repair_jobs as $repair_job)
                        <tr>
                            <td> {{ $repair_job->id }}</td>
                            <td> {{ $repair_job->customer->name }} </td>
                            <td> {{ $repair_job->machine_model->name }}</td>
                            <td> {{ $repair_job->due_amount }} </td>
                            <td> {{ $repair_job->created_at->format('d/m/Y') }}</td>
                            <td> <?php
                            $today = date('d-m-Y');
                            $cday = $repair_job->created_at->format('d-m-Y');
                            $dt1 = strtotime($today);
                            $dt2 = strtotime($cday);
                            $diff = $dt1 - $dt2;
                            echo $diff / (24 * 60 * 60);
                            ?></td>
                        </tr>
                    @endforeach
                @else
                    <tr>No Data Found</tr>
                @endif
            </tbody>

        </table>
    </div>
    <script>
        new DataTable('#example', {
            info: false,
            lengthChange: false,
            pageLength: 300,
            order: [0, 'desc'],
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
</x-admin.nav>
