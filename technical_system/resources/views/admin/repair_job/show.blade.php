<x-admin.nav>
    <style>
        div.fixed-btn {
            position: -webkit-sticky;
            position: sticky;
            top: 50px;
            z-index: 100;

        }
    </style>

    <div class="container">
        <div class="fixed-btn">
            <div class="row p-2">
                <div class="col-12">
                    <a href="{{ route('repair_job.index') }}" class="btn btn-block btn-primary"><i
                            class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
                </div>
            </div>
        </div>
        @if ($repair_job->current_status_id > 3)
            <div class="row p-2 ">
                <div class="col-6">
                    <a href="{{ route('repair_job.print', $repair_job->id) }}"
                        class="btn btn-block btn-secondary">PRINT</a>
                </div>
                {{-- @can('managers-only') --}}
                <div class="col-6">
                    <a href="{{ route('repair_job.printDetail', $repair_job->id) }}"
                        class="btn btn-block btn-secondary">PRINT
                        DETAILS</a>
                </div>
                {{-- @endcan --}}
            </div>
        @endif
        <div class="row p-2 ">
            <div class="col-6">
                @if ($repair_job->current_status_id == 1)
                    <a href="{{ route('repair_job.start', $repair_job) }}" class="btn btn-block btn-success">Start Job</a>
                @elseif($repair_job->current_status_id == 2)
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('repair_job.close', $repair_job->id) }}"
                                class="btn btn-block btn-success m-1 p-1">Close Job
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('repair_job.estimate', $repair_job->id) }}"
                                class="btn btn-block btn-success m-1 p-1">Estimate Job
                            </a>
                        </div>
                    </div>
                @elseif($repair_job->current_status_id == 3)
                    <a href="{{ route('repair_job.close', $repair_job->id) }}" class="btn btn-block btn-success">Close Job
                    </a>
                @elseif($repair_job->current_status_id == 4)
                    <a href="{{ route('repair_job.deliverPage', $repair_job->id) }}" class="btn btn-block btn-success">Deliver
                        Job</a>
                @endif
            </div>

            <div class="col-6">
                <form action="{{ route('repair_job.uploadImagepage', $repair_job->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-block btn-warning">Upload Image</button>
                </form>
            </div>
        </div>

        {{-- @can('director-only') --}}
        <div class="row p-2 ">
            <div class="col-6">
                <form action="{{ route('repair_job.destroy', $repair_job->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-block btn-danger">Delete</button>
                </form>
            </div>

            <div class="col-6">
                <a href="{{ route('repair_job.edit', $repair_job->id) }}" class="btn btn-block btn-primary">Edit job</a>
            </div>
        </div>
        {{-- @endcan --}}

        <table class="table table-bordered" style="table-layout: fixed;">
            <tbody>
                <tr>
                    <td style="width:50%">
                        Warranty Status
                    </td>
                    <td style="width:50%">
                        <div class="px-5">
                            {{-- @can('director-only') --}}
                                <form action="{{ route('repair_job.changeWarranty', $repair_job->id) }}" method="post">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                            @if ($repair_job->warranty_type == 'With-Warranty') @checked(true) @endif
                                            onChange="this.form.submit()">
                                        <label class="form-check-label" for="exampleCheck1">
                                            @if ($repair_job->warranty_type == 'With-Warranty')
                                                With Warranty
                                            @else
                                                Without Warranty
                                            @endif
                                        </label>
                                    </div>
                                </form>
                            {{-- @endcan --}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td> Customer Name</td>
                    <td> {{ $repair_job->customer->name }} </td>
                </tr>
                <tr>
                    <td> Model : </td>
                    <td> {{ $repair_job->machine_model->name }} </td>
                </tr>
                <tr>
                    <td> Serial Number : </td>
                    <td> {{ $repair_job->serial_number }}</td>
                </tr>
                <tr>
                    <td>Method came In : </td>
                    <td> {{ $repair_job->method_came_in }}</td>
                </tr>
                <tr>
                    <td>Final Total amount : </td>
                    <td> {{ $repair_job->final_total }}</td>
                </tr>
                <tr>
                    <td>Issue of the Machine : </td>
                    <td> {{ $repair_job->issue }}</td>
                </tr>
                <tr>
                    <td>Comments : </td>
                    <td> {{ $repair_job->comment }}</td>
                </tr>
                <tr>
                    <td>Prompt Out : </td>
                    <td> {{ $repair_job->method_going_out }}</td>
                </tr>
            </tbody>
        </table>
        @if ($components_added->count() > 0)
            <table class="table table-bordered" style="table-layout: fixed;">
                <tbody>
                    <tr>
                        <td style="text-align: center"><strong>Components added </strong> </td>
                        <td style="text-align: center"> <strong>Qty </strong> </td>
                    </tr>
                    @foreach ($components_added as $c)
                        <tr>
                            <td style="text-align: center"> {{ $c->component->name }} </td>
                            <td style="text-align: center"> {{ $c->qty }}pcs</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <table class="table table-bordered" style="table-layout: fixed;">
            <tr>
                <th style="text-align: center">Job Status</th>
                <th style="text-align: center">Status Owner</th>
                <th style="text-align: center">Status Time</th>
            </tr>
            @foreach ($repair_job_statuses as $JS)
                <tr>
                    <td>{{ $JS->status->status }}</td>
                    <td>{{ $JS->user->name }}</td>
                    <td>{{ $JS->created_at }}</td>

                </tr>
            @endforeach

        </table>

        @foreach ($images as $image)
            <div class="col-12 pt-2">
                <img src="{{ URL::asset($image) }}" style="width: 100%" />
                <img src="{{ asset($image) }}" style="width: 100%" />
                <p>{{ URL::asset($image) }}</p>
                <p>{{ asset($image) }}</p>
            </div>
        @endforeach

        {{-- //this is for the server --}}
        {{-- @foreach ($images as $image)
        <div class="col-12 pt-2">
            <img src="{{ asset($image) }}" style="width: 100%" />
        </div>
    @endforeach --}}

    </div>
</x-admin.nav>
