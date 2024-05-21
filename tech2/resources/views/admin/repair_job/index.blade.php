<x-admin.nav>
    <div class="container pt-2">
        <a class="btn btn-primary" href="{{ route('repair_job.create') }}" role="button">Create New Repair Job</a>
        <div class="table">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>View Job</th>
                        <th>Customer</th>
                        <th>Model </th>
                        <th>Serial Number </th>
                        <th>Status </th>
                        <th>Warranty </th>
                        <th>Previous </th>
                        <th>Total Amount Rs.</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($repair_jobs))
                        @foreach ($repair_jobs as $repair_job)
                            <tr @if ($repair_job->warranty_type == 'With-Warranty' && $repair_job->repair_job_status->status != 'Job-Delivered') class="table-danger" @endif>
                                <td> {{ $repair_job->id }}</td>
                                <td> <a href="{{ route('repair_job.show', $repair_job->id) }}"
                                        class="btn btn-primary" target="_blank">view</a></td>
                                <td> {{ $repair_job->customer->name }} </td>
                                <td> {{ $repair_job->machine_model->name }}</td>
                                <td> {{ $repair_job->serial_number }} </td>
                                <td> {{ $repair_job->repair_job_status->status }}</td>
                                <td> {{ $repair_job->warranty_type }}</td>
                                <td> {{ $repair_job->repairTimes }} </td>
                                <td> {{ $repair_job->final_total }}</td>
                                <td> {{ $repair_job->created_at }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>No Data Found</tr>
                    @endif
                </tbody>

            </table>
        </div>

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
        <div class="float-right">
            {{ $repair_jobs->links() }}
        </div>
</x-admin.nav>
