<x-admin.nav>
    <div class="container pt-2">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            .ui-autocomplete {
                max-height: 100px;
                overflow-y: auto;
                overflow-x: hidden;
            }

            * html .ui-autocomplete {
                height: 100px;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {
                var cusJqery = {!! json_encode($customers) !!};
                var cusName = [];
                for (var ckj = 0; ckj < cusJqery.length; ckj++) {
                    cusName.push(cusJqery[ckj].name);
                }

                $("#customer_name").autocomplete({
                    source: cusName
                });
            });
        </script>
        <script>
            $(function() {
                var models = {!! json_encode($machine_models->toArray()) !!};
                var modelsArray = [];
                for (var ckj = 0; ckj < models.length; ckj++) {
                    modelsArray.push(models[ckj].name);
                }

                $("#model").autocomplete({
                    source: modelsArray
                });
            });
        </script>
        <form method="POST" action="{{ route('repair_job.show_find') }}" onsubmit="return validateForm()">
            @csrf

            <div class="form-group">
                <label for="customer_name">Customer </label>
                <input id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                @error('customer_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" aria-describedby="model"
                    value="{{ old('model') }}">
                @error('model')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="job_id">Job id</label>
                <input type="number" class="form-control" id="job_id" name="job_id" aria-describedby="job_id"
                    value="{{ old('job_id') }}">
                @error('job_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Find Job</button>
                </div>
            </div>
        </form>
        <script>
            function validateForm() {

                myButton = document.getElementById("submitButton");
                myButton.disabled = true;
                return true;
            }
        </script>

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
                                    class="btn btn-primary">view</a></td>
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

    </div>
</x-admin.nav>
