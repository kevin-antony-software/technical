<x-admin.nav>
    <div class="container pt-2">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('courier_pickup.create') }}" class="btn btn-primary ">Add new PickUp</a>
            </div>
        </div>
        <div class="pt-2">
            <table id="example" class="display" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer Name </th>
                        <th>Status</th>
                        <th>Date </th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($Courierpickups))
                        @foreach ($Courierpickups as $Courierpickup)
                            <tr>
                                <td> {{ $Courierpickup->id }}</td>
                                <td> {{ $Courierpickup->customer->name }} </td>
                                <td> {{ $Courierpickup->status }} </td>
                                <td> {{ $Courierpickup->created_at }} </td>
                                @if ($Courierpickup->status == 'pending')
                                    <td>
                                        <div class="row">
                                            <form action="{{ route('courier_pickup.update', $Courierpickup->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="COPICKID" id="COPICKID"
                                                    value="{{ $Courierpickup->id }}" hidden>
                                                <button class="btn btn-primary p-2 m-2" value="submit">Receive</button>
                                            </form>
                                            <a class="btn btn-danger p-2 m-2"
                                                href="{{ route('courier_pickup.edit', $Courierpickup->id) }}">Send
                                                Reminder</a>
                                        </div>
                                    </td>
                                @else
                                    <td>Received</td>
                                @endif

                            </tr>
                        @endforeach
                    @else
                        <tr> No Data Found </tr>
                    @endif
                </tbody>
            </table>
        </div>
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
