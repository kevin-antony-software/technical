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
        <div class="row p-2 ">
            <div class="col-6">
                <a href="{{ route('repair_job.print', $job->id) }}" class="btn btn-block btn-secondary">PRINT</a>
            </div>
            @can('managers-only')
                <div class="col-6">
                    <a href="{{ route('repair_job.printDetail', $job->id) }}" class="btn btn-block btn-secondary">PRINT
                        DETAILS</a>
                </div>
            @endcan
        </div>
        <div class="row p-2 ">
            <div class="col-6">
                @if ($job->jobStatus == 'Job-Created')
                    <a href="{{ route('repair_job.start', $job->id) }}" class="btn btn-block btn-success">Start Job</a>
                @elseif($job->jobStatus == 'Job-Started')
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('repair_job.close', $job->id) }}"
                                class="btn btn-block btn-success m-1 p-1">Close Job
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('repair_job.estimate', $job->id) }}"
                                class="btn btn-block btn-success m-1 p-1">Estimate Job
                            </a>
                        </div>
                    </div>
                @elseif($job->jobStatus == 'Job-Estimated')
                    <a href="{{ route('repair_job.close', $job->id) }}" class="btn btn-block btn-success">Close Job
                    </a>
                @elseif($job->jobStatus == 'Job-Closed')
                    <a href="{{ route('repair_job.deliverPage', $job->id) }}" class="btn btn-block btn-success">Deliver
                        Job</a>
                @endif
            </div>
            <div class="col-6">
                <form action="{{ route('repair_job.uploadImagepage', $job->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-block btn-warning">Upload Image</button>
                </form>
            </div>
        </div>
        @can('director-only')
            <div class="row p-2 ">
                <div class="col-6">
                    <form action="{{ route('repair_job.destroy', $job->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-block btn-danger">Delete</button>
                    </form>
                </div>

                <div class="col-6">
                    <a href="{{ route('repair_job.edit', $job->id) }}" class="btn btn-block btn-primary">Edit job</a>
                </div>
            </div>
        @endcan


        <table class="table table-bordered" style="table-layout: fixed;">
            <tbody>
                <tr>
                    <td style="width:50%">
                        Warranty Status
                    </td>
                    <td style="width:50%">
                        <div class="px-5">
                            @can('director-only')
                                <form action="{{ route('repair_job.changeWarranty', $job->id) }}" method="post">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                            @if ($job->warranty == 'withWarranty') @checked(true) @endif
                                            onChange="this.form.submit()">
                                        <label class="form-check-label" for="exampleCheck1">
                                            @if ($job->warranty == 'withWarranty')
                                                With Warranty
                                            @else
                                                Without Warranty
                                            @endif
                                        </label>
                                    </div>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                <tr>
                    <td> Customer Name</td>
                    <td> {{ $job->customer_name }} </td>
                </tr>
                <tr>
                    <td> Model : </td>
                    <td> {{ $job->model }} </td>
                </tr>
                <tr>
                    <td> Serial Number : </td>
                    <td> {{ $job->serialNum }}</td>
                </tr>
                <tr>
                    <td>Prompt In : </td>
                    <td> {{ $job->promptIn }}</td>
                </tr>
                <tr>
                    <td>Sold Date : </td>
                    <td> {{ $job->soldDate }}</td>
                </tr>

                <tr>
                    <td>Final Total amount : </td>
                    <td> {{ $job->finalTotal }}</td>
                </tr>
                <tr>
                    <td>Issue of the Machine : </td>
                    <td> {{ $job->issue }}</td>
                </tr>
                <tr>
                    <td>Comments : </td>
                    <td> {{ $job->comment }}</td>
                </tr>
                <tr>
                    <td>Prompt Out : </td>
                    <td> {{ $job->promptOut }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" style="table-layout: fixed;">
            <tbody>
                <tr>
                    <td style="text-align: center"><strong>Components added </strong> </td>
                    <td style="text-align: center"> <strong>Qty </strong> </td>
                </tr>
                @foreach ($componentsAdded as $c)
                    <tr>
                        <td style="text-align: center"> {{ $c->component_name }} </td>
                        <td style="text-align: center"> {{ $c->qty }}pcs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <table class="table table-bordered" style="table-layout: fixed;">
            <tr>
                <th style="text-align: center">Job Status</th>
                <th style="text-align: center">Status Owner</th>
                <th style="text-align: center">Status Time</th>
            </tr>
            @foreach ($job_statuses as $JS)
                <tr>
                    <td>{{ $JS->JobStatus->status_name }}</td>
                    <td>{{ $JS->user->name }}</td>
                    <td>{{ $JS->created_at }}</td>

                </tr>
            @endforeach

        </table>

        @foreach ($images as $image)
            <div class="col-12 pt-2">
                <img src="{{ URL::asset($image) }}" style="width: 100%" />
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
